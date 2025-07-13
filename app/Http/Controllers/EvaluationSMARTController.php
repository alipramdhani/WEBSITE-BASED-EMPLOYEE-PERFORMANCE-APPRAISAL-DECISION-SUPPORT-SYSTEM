<?php

namespace App\Http\Controllers;


use App\Models\Criteria;
use App\Models\User;
use App\Models\EvaluationEmployeeData;
use App\Http\Helpers\EvaluationProcessor;
use App\Models\FinalScoreTotal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EvaluationSMARTController extends Controller
{
    public function showEvaluationForm(Request $request)
    {
        /* 1. Tentukan role pengguna ‑ superadmin | admin | employee */
        $userRole = Auth::user()->role;

        /* 2. Ambil daftar user sesuai role */
        $users = User::query()
            ->when($userRole !== 'superadmin', fn($q) => $q->where('role', $userRole))
            ->get();

        /* 3. Tahun yang dipilih (default = tahun berjalan) */
        $tahun = $request->input('evaluation_years', now()->year);

        /* 4. Data statis */
        $criteria   = Criteria::all();
        $criteriaP  = Criteria::where('type', 'Performance')->orderBy('id')->get();
        $criteriaWA = Criteria::where('type', 'Work Attitude')->orderBy('id')->get();

        /* 5. Data dinamis tergantung tahun */
        $finalScoreTotal = FinalScoreTotal::where('evaluation_years', $tahun)->get();

        $employeDataStatus = EvaluationEmployeeData::select(
            'id',                // tetap dibawa bila dibutuhkan
            'alternatif',        // <‑‑ tambahkan
            'fullname',
            'departement',
            'employeementStatus',
            'evaluation_stage'
        )
            ->where('evaluation_years', $tahun)
            ->groupBy(
                'id',
                'alternatif',
                'fullname',
                'departement',
                'employeementStatus',
                'evaluation_stage'
            )
            ->get();

        /* 6. Siapkan penampung ‑ gunakan kunci = alternatif */
        $evaluations     = [];
        $utilities       = [];
        $finalScoreSmart = [];
        $stageCount      = [];

        /* 7. Ambil data per‑tahap T1‑T3 */
        foreach ($employeDataStatus as $eds) {
            $alt = $eds->alternatif;          // kunci unik karyawan

            for ($t = 1; $t <= 3; $t++) {
                $evaluations["t$t"][$alt] = DB::table("evaluations_t$t")
                    ->where('evaluation_years', $tahun)
                    ->where('alternatif', $alt)
                    ->first();

                $utilities["t$t"][$alt] = DB::table("utilities_results_t$t")
                    ->where('evaluation_years', $tahun)
                    ->where('alternatif', $alt)
                    ->first();

                $finalScoreSmart["t$t"][$alt] = DB::table("final_score_smart_t$t")
                    ->where('evaluation_years', $tahun)
                    ->where('alternatif', $alt)
                    ->first();
            }

            // Hitung berapa tahap sudah selesai (punya final score)
            $stageCount[$alt] = collect([
                $finalScoreSmart["t1"][$alt] ?? null,
                $finalScoreSmart["t2"][$alt] ?? null,
                $finalScoreSmart["t3"][$alt] ?? null,
            ])->filter()->count();
        }

        /* 8. Kirim ke view */
        return view('layouts.admins.evaluation', [
            'users'             => $users,
            'criteria'          => $criteria,
            'criteriaP'         => $criteriaP,
            'criteriaWA'        => $criteriaWA,
            'employeDataStatus' => $employeDataStatus,
            'evaluations'       => $evaluations,
            'utilities'         => $utilities,
            'finalScoreSmart'   => $finalScoreSmart,
            'stageCount'        => $stageCount,
            'tahun'             => $tahun,
            'userRole'          => $userRole,
        ]);
    }

    public function storeEvaluation(Request $request)
    {
        // === 1. Validasi data ===
        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'evaluation_years' => 'required|integer',
            'evaluation_stage' => 'required|string|in:T1,T2,T3',
        ] + collect(range(1, 15))->mapWithKeys(fn($i) => ["C$i" => 'required|numeric|min:20|max:100'])->toArray());

        $user  = User::findOrFail($validated['user_id']);
        $tahap = strtolower($validated['evaluation_stage']); // 't1', 't2', 't3'
        $tahun = $validated['evaluation_years'];

        // === 2. Ambil 'alternatif' karyawan berdasarkan email di evaluation_employee_data ===
        $alternatif = DB::table('evaluation_employee_data')
            ->where('email', $user->email)
            ->where('evaluation_stage', strtoupper($tahap))
            ->where('evaluation_years', $tahun)
            ->value('alternatif');

        // === 3. Cek apakah sudah ada data di tabel evaluations_{tahap} ===
        $tableName = "evaluations_$tahap";
        $isExist = DB::table($tableName)
            ->where('alternatif', $alternatif)
            ->where('evaluation_years', $tahun)
            ->exists();

        if ($isExist) {
            return back()->withInput()->with([
                'alert_status'  => false,
                'alert_title'   => 'Gagal Menyimpan!',
                'alert_message' => 'Evaluasi sudah diisi!',
            ]);
        }

        // === 4. Lolos: proses evaluasi ===
        \App\Http\Helpers\EvaluationProcessor::process($validated, $user);

        return back()->with([
            'alert_status'  => true,
            'alert_title'   => 'Evaluation Success!',
            'alert_message' => 'Hasil Evaluasi Berhasil Disimpan',
        ]);
    }

    public function deleteStageResults(Request $request)
    {
        $alternatif = $request->input('alternatif');             // ← gunakan alternatif, bukan id
        $tahun      = $request->input('evaluation_years');
        $tahapList  = $request->input('tahap', []);              // contoh: ['t1','t3']

        // Validasi apakah data evaluation_employee_data dengan alternatif & tahun tersebut ada
        $employeeRow = DB::table('evaluation_employee_data')
            ->where('alternatif', $alternatif)
            ->where('evaluation_years', $tahun)
            ->first();

        if (!$employeeRow) {
            return back()->with('error', 'Data evaluasi tidak ditemukan.');
        }

        // Jalankan proses penghapusan dalam transaksi
        DB::transaction(function () use ($tahapList, $alternatif, $tahun) {

            foreach ($tahapList as $tahap) {
                $tahap = strtolower($tahap);

                if (!in_array($tahap, ['t1', 't2', 't3'])) {
                    continue; // Abaikan input tahap tidak valid
                }

                DB::table("evaluations_{$tahap}")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->delete();

                DB::table("utilities_results_{$tahap}")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->delete();

                DB::table("final_score_smart_{$tahap}")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->delete();
            }

            // Cek apakah masih ada skor SMART di tahap lain untuk tahun yang sama
            $masihAdaTahapan = collect(['t1', 't2', 't3'])->first(function ($tahap) use ($alternatif, $tahun) {
                return DB::table("final_score_smart_{$tahap}")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->exists();
            });

            // Jika semua tahap kosong, hapus evaluation_employee_data pada tahun tersebut
            if (is_null($masihAdaTahapan)) {
                DB::table('evaluation_employee_data')
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->delete();

                // Optional: Hapus dari final_score_totals jika tidak ada data evaluasi sama sekali
                $adaDiTahunLain = DB::table('evaluation_employee_data')
                    ->where('alternatif', $alternatif)
                    ->exists();

                if (!$adaDiTahunLain) {
                    DB::table('final_score_totals')
                        ->where('alternatif', $alternatif)
                        ->delete();
                }
            }
        });

        return back()->with('success', 'Data hasil evaluasi berhasil dihapus.');
    }


    protected function generatePdf($id, $tahap, $download = true)
    {
        $user = EvaluationEmployeeData::select('id', 'fullname', 'departement', 'employeementStatus')->findOrFail($id);
        $criteria = Criteria::orderBy('id')->get();

        $evaluations = [];
        $utilities = [];
        $finalScoreSmart = [];

        for ($t = 1; $t <= 3; $t++) {
            $alt = 'A' . $id;
            $evaluations["t$t"][$id] = DB::table("evaluations_t$t")->where('alternatif', $alt)->first();
            $utilities["t$t"][$id] = DB::table("utilities_results_t$t")->where('alternatif', $alt)->first();
            $finalScoreSmart["t$t"][$id] = DB::table("final_score_smart_t$t")->where('alternatif', $alt)->first();
        }

        $pdf = PDF::loadView('exports.evaluation_pdf', [
            'user' => $user,
            'criteria' => $criteria,
            'evaluations' => $evaluations,
            'utilities' => $utilities,
            'finalScoreSmart' => $finalScoreSmart,
            'tahap' => $tahap
        ]);

        return $download
            ? $pdf->download("Evaluasi_{$user->fullname}_{$tahap}.pdf")
            : $pdf->stream("Evaluasi_{$user->fullname}_{$tahap}.pdf");
    }

    public function downloadPDFSMART($id, $tahap)
    {
        return $this->generatePdf($id, $tahap, true);
    }
}
