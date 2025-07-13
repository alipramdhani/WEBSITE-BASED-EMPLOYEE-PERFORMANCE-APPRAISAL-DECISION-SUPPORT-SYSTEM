<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CentroidFirst;
use App\Models\ClusteringResult;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\EvaluationEmployeeData;
use App\Models\FinalScoreTotal;
use App\Models\User;
use App\Models\UtilitiesResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EvaluationResultController extends Controller
{
    public function showEvaluationResult(Request $request)
    {
        //======== cek title sesuai role =========
        $userRole = Auth::user()->role;

        $users = User::when(
            $userRole === 'superadmin',
            fn($q) => $q->where('role', 'superadmin'),
            fn($q) => $q->where('role', 'admin'),
            fn($q) => $q->where('role', 'employee'),
        )->get();
        //======== cek title sesuai role =========

        $tahun = $request->input('evaluation_years', now()->year);
        $tahap = strtolower($request->input('evaluation_stage', 't1'));
        $activeTab = $request->get('tab', 'evaluation');

        $criteria = Criteria::all();

        // Ambil data pegawai
        $employeDataStatus = EvaluationEmployeeData::select('fullname', 'departement', 'employeementStatus', 'id', 'evaluation_stage')
            ->groupBy('fullname', 'departement', 'employeementStatus', 'id', 'evaluation_stage')
            ->get();

        $evaluations = [];
        $utilities = [];
        $finalScoreSmart = [];
        $stageCount = [];

        // Inisialisasi data per karyawan dan tahap (t1 - t3)
        foreach ($employeDataStatus as $eds) {
            for ($t = 1; $t <= 3; $t++) {
                $alt = 'A' . $eds->id;

                $evaluations["t$t"][$eds->id] = DB::table("evaluations_t$t")
                    ->where('alternatif', $alt)
                    ->first() ?? null;

                $utilities["t$t"][$eds->id] = DB::table("utilities_results_t$t")
                    ->where('alternatif', $alt)
                    ->first() ?? null;

                $finalScoreSmart["t$t"][$eds->id] = DB::table("final_score_smart_t$t")
                    ->where('alternatif', $alt)
                    ->first() ?? null;
            }

            // Hitung jumlah tahap yang sudah diisi
            $stages = explode(',', $eds->evaluation_stage);
            $stageCount[$eds->id] = count(array_filter($stages));
        }

        // Filter ulang berdasarkan tahun dan keyBy ID agar akses tetap per ID
        foreach (['t1', 't2', 't3'] as $stage) {
            $evaluations[$stage] = DB::table("evaluations_$stage")
                ->join('evaluation_employee_data', "evaluations_$stage.id", '=', 'evaluation_employee_data.id')
                ->where('evaluation_employee_data.evaluation_years', $tahun)
                ->select("evaluations_$stage.*", 'evaluation_employee_data.alternatif')
                ->get()
                ->keyBy('id'); // penting!

            $utilities[$stage] = DB::table("utilities_results_$stage")
                ->join('evaluation_employee_data', "utilities_results_$stage.id", '=', 'evaluation_employee_data.id')
                ->where('evaluation_employee_data.evaluation_years', $tahun)
                ->select("utilities_results_$stage.*", 'evaluation_employee_data.alternatif')
                ->get()
                ->keyBy('id'); // penting!

            $finalScoreSmart[$stage] = DB::table("final_score_smart_$stage")
                ->join('evaluation_employee_data', "final_score_smart_$stage.id", '=', 'evaluation_employee_data.id')
                ->where('evaluation_employee_data.evaluation_years', $tahun)
                ->select("final_score_smart_$stage.*", 'evaluation_employee_data.alternatif')
                ->get()
                ->keyBy('id'); // penting!
        }

        // Data total skor akhir
        $finalScoreTotal = DB::table('final_score_totals')
            ->where('evaluation_years', $tahun)
            ->paginate(10);

        // Centroid awal (k-means)
        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)
            ->where('status', 'Awal')
            ->get();

        // Hasil clustering
        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->orderBy('cluster', 'asc')
            ->get();

        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        return view('layouts.admins.evaluationResult', compact(
            'evaluations',
            'utilities',
            'finalScoreSmart',
            'finalScoreTotal',
            'employeDataStatus',
            'stageCount',
            'tahap',
            'tahun',
            'activeTab',
            'centroidFirst',
            'kmeansResult',
            'criteria',
            'cluster1',
            'cluster2',
            'cluster3',
            'userRole',
            'users'
        ));
    }


    public function downloadPDFKMEANS(Request $request)
    {
        $tahun = $request->input('evaluation_years', now()->year);

        // Ambil data final score + data karyawan dari evaluation_employee_data
        $finalScoreTotal = DB::table('final_score_totals as f')
            ->join('evaluation_employee_data as e', function ($join) use ($tahun) {
                $join->on('f.id', '=', 'e.id')
                    ->where('e.evaluation_years', '=', $tahun);
            })
            ->where('f.evaluation_years', $tahun)
            ->select('f.final_score_total', 'e.fullname', 'e.departement', 'e.employeementStatus')
            ->get();

        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)->get();

        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->orderBy('cluster', 'asc')
            ->get();

        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        $pdf = Pdf::loadView('exports.downloadKMEANSResult', compact(
            'tahun',
            'finalScoreTotal',
            'centroidFirst',
            'kmeansResult',
            'cluster1',
            'cluster2',
            'cluster3'
        ));

        return $pdf->download("Hasil_Clustering_Karyawan_{$tahun}.pdf");
    }

    public function previewPDFKMEANS(Request $request)
    {
        $tahun = $request->input('evaluation_years', now()->year);

        $finalScoreTotal = DB::table('final_score_totals as f')
            ->join('evaluation_employee_data as e', function ($join) use ($tahun) {
                $join->on('f.id', '=', 'e.id')
                    ->where('e.evaluation_years', '=', $tahun);
            })
            ->where('f.evaluation_years', $tahun)
            ->select('f.final_score_total', 'e.fullname', 'e.departement', 'e.employeementStatus')
            ->get();

        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)->get();

        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->orderBy('cluster', 'asc')
            ->get();

        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        $pdf = Pdf::loadView('exports.downloadKMEANSResult', compact(
            'tahun',
            'finalScoreTotal',
            'centroidFirst',
            'kmeansResult',
            'cluster1',
            'cluster2',
            'cluster3'
        ));

        return $pdf->stream("Preview_Hasil_Clustering_Karyawan_{$tahun}.pdf");
    }


    // ============ Generate PDF ==============

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

        $pdf = PDF::loadView('exports.downloadSMARTResult', [
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
    // ============ Download PDF Tahap 1 - 3 ==============
    public function downloadPDFSMART($id, $tahap)
    {
        return $this->generatePdf($id, $tahap, true);
    }




    // ==================== DOWNLOAD PDF ====================
    public function downloadAll(Request $request)
    {
        $tahun = $request->input('evaluation_years', now()->year);

        // Hanya ambil data yang valid sesuai tahun
        $evaluationData = EvaluationEmployeeData::where('evaluation_years', $tahun)->get();
        $criteria = Criteria::orderBy('id')->get();

        // Ambil data yang tersedia untuk tahun yang dipilih
        $finalScoreTotal = FinalScoreTotal::where('evaluation_years', $tahun)
            ->whereNotNull('final_score_total') // pastikan terisi
            ->get();

        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)
            ->where('status', 'Awal')
            ->get();

        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->whereNotNull('cluster') // hanya data yang sudah di-cluster
            ->get();

        // Bagi hasil cluster
        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        $pdf = Pdf::loadView('exports.downloadAllResult', compact(
            'tahun',
            'evaluationData',
            'criteria',
            'finalScoreTotal',
            'centroidFirst',
            'kmeansResult',
            'cluster1',
            'cluster2',
            'cluster3'
        ))->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Evaluasi_Clustering_Karyawan_{$tahun}.pdf");
    }


    public function previewAll(Request $request)
    {
        $tahun = $request->input('evaluation_years', now()->year);

        $evaluationData = EvaluationEmployeeData::where('evaluation_years', $tahun)->get();
        $criteria = Criteria::orderBy('id')->get();

        $finalScoreTotal = FinalScoreTotal::where('evaluation_years', $tahun)
            ->whereNotNull('final_score_total')
            ->get();

        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)
            ->where('status', 'Awal')
            ->get();

        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->whereNotNull('cluster')
            ->get();

        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        $pdf = Pdf::loadView('exports.downloadAllResult', compact(
            'tahun',
            'evaluationData',
            'criteria',
            'finalScoreTotal',
            'centroidFirst',
            'kmeansResult',
            'cluster1',
            'cluster2',
            'cluster3'
        ))->setPaper('A4', 'portrait');

        return $pdf->stream("Preview_Laporan_Evaluasi_Clustering_{$tahun}.pdf");
    }
}
