<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Criteria;
use App\Models\User;

class EvaluationProcessor
{
    public static function process(array $validated, User $user): void
    {
        $tahap = strtolower($validated['evaluation_stage']); // 't1', 't2', 't3'
        $tahun = $validated['evaluation_years'];

        // === 1. Pastikan ada di evaluation_employee_data ===
        $existingRow = DB::table('evaluation_employee_data')
            ->where('email', $user->email)
            ->where('evaluation_years', $tahun)
            ->where('evaluation_stage', strtoupper($tahap))
            ->first();

        if (!$existingRow) {
            $firstAlt = DB::table('evaluation_employee_data')
                ->where('email', $user->email)
                ->orderBy('id')
                ->value('alternatif');

            $alternatif = $firstAlt ?: 'A' . $user->id;

            DB::table('evaluation_employee_data')->insert([
                'fullname'           => $user->fullname,
                'email'              => $user->email,
                'departement'        => $user->departement,
                'employeementStatus' => $user->employeementStatus,
                'evaluation_years'   => $tahun,
                'evaluation_stage'   => strtoupper($tahap),
                'alternatif'         => $alternatif,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        } else {
            $alternatif = $existingRow->alternatif;
        }

        // === 2. Simpan ke evaluations_t{n} ===
        $evaluasiData = [
            'alternatif'       => $alternatif,
            'evaluation_years' => $tahun,
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
        foreach (range(1, 15) as $i) {
            $evaluasiData["C$i"] = $validated["C$i"];
        }
        DB::table("evaluations_$tahap")->insert($evaluasiData);

        // === 3. Ambil semua alternatif valid di tahap & tahun ini ===
        $alternatifValid = DB::table('evaluation_employee_data')
            ->where('evaluation_stage', strtoupper($tahap))
            ->where('evaluation_years', $tahun)
            ->pluck('alternatif')
            ->toArray();

        if (empty($alternatifValid)) return;

        // === 4. Ambil data evaluasi dari alternatif valid ===
        $evaluasiAll = DB::table("evaluations_$tahap")
            ->where('evaluation_years', $tahun)
            ->whereIn('alternatif', $alternatifValid)
            ->get();

        // === 5. Hitung Utility (C1–C15) ===
        // Ambil semua data evaluasi dari tahap yang dimaksud
        $evaluasiAll = DB::table("evaluations_$tahap")
            ->where('evaluation_years', $tahun)
            ->whereIn('alternatif', $alternatifValid)
            ->get();

        // Hitung nilai Cmin dan Cmax dari semua alternatif
        $cmin = $cmax = [];
        foreach (range(1, 15) as $i) {
            $col = "C$i";
            $cmin[$col] = $evaluasiAll->min($col);
            $cmax[$col] = $evaluasiAll->max($col);
        }

        // Hapus data sebelumnya di tabel utility dan reset AUTO_INCREMENT
        DB::table("utilities_results_$tahap")
            ->where('evaluation_years', $tahun)
            ->whereIn('alternatif', $alternatifValid)
            ->delete();

        DB::statement("ALTER TABLE utilities_results_$tahap AUTO_INCREMENT = 1");

        // Hitung utility (semua *benefit*)
        foreach ($evaluasiAll as $row) {
            $utility = [
                'alternatif'       => $row->alternatif,
                'evaluation_years' => $tahun,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            foreach (range(1, 15) as $i) {
                $col   = "C$i";
                $min   = $cmin[$col];
                $max   = $cmax[$col];
                $value = $row->$col;

                $utility[$col] = ($max != $min)
                    ? round(($value - $min) / ($max - $min), 3) // rumus *benefit* untuk semua C1–C15
                    : 0;
            }

            DB::table("utilities_results_$tahap")->insert($utility);
        }

        // === 6. Hitung nilai SMART dan simpan ke final_score_smart_t{n} ===
        $weights = Criteria::all()
            ->pluck('normalized_weight', 'code')
            ->toArray();

        $utilityAll = DB::table("utilities_results_$tahap")
            ->where('evaluation_years', $tahun)
            ->whereIn('alternatif', $alternatifValid)
            ->get();

        DB::table("final_score_smart_$tahap")
            ->where('evaluation_years', $tahun)
            ->whereIn('alternatif', $alternatifValid)
            ->delete();

        // ✅ RESET AUTO_INCREMENT untuk final_score_smart_{tahap}
        DB::statement("ALTER TABLE final_score_smart_$tahap AUTO_INCREMENT = 1");

        foreach ($utilityAll as $row) {
            $smart = [
                'alternatif'       => $row->alternatif,
                'evaluation_years' => $tahun,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
            foreach (range(1, 15) as $i) {
                $col = "C$i";
                $smart[$col] = round(($row->$col ?? 0) * ($weights[$col] ?? 0), 4);
            }
            DB::table("final_score_smart_$tahap")->insert($smart);
        }

        // === 7. Ambil semua alternatif unik di tahun & tahap aktif ===
        $alternatifList = collect(['t1', 't2', 't3'])
            ->flatMap(function ($stage) use ($tahun) {
                return DB::table("final_score_smart_$stage")
                    ->where('evaluation_years', $tahun)   // ⬅️ filter tahun
                    ->pluck('alternatif');
            })
            ->unique()
            ->values();

        // === Iterasi setiap alternatif di tahun ini ===
        foreach ($alternatifList as $alternatif) {
            $scores = [];

            foreach (['t1', 't2', 't3'] as $stage) {
                $smartRow = DB::table("final_score_smart_$stage")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)   // ⬅️ filter tahun
                    ->first();

                $scores[$stage] = $smartRow
                    ? collect(range(1, 15))
                    ->sum(fn($i) => $smartRow->{"C$i"} ?? 0)
                    : null;
            }

            // Cari data pegawai di tahun ini
            $employee = DB::table('evaluation_employee_data')
                ->where('alternatif', $alternatif)
                ->where('evaluation_years', $tahun)       // ⬅️ filter tahun
                ->first();

            if (!$employee) {
                continue;
            }

            // Susun payload
            $payload = [
                'fullname'         => $employee->fullname,
                'alternatif'       => $alternatif,
                'evaluation_years' => $tahun,
                'score_t1'         => $scores['t1'],
                'score_t2'         => $scores['t2'],
                'score_t3'         => $scores['t3'],
                'updated_at'       => now(),
            ];

            // Hitung rata‑rata jika ketiganya terisi
            if (collect($scores)->filter()->count() === 3) {
                $finalScore = round(array_sum($scores) / 3, 4);
                $payload['final_score_total'] = $finalScore;
                $payload['information'] = match (true) {
                    $finalScore > 0.8  => 'Selamat, kinerja kamu sangat baik. Pertahankan dan terus tingkatkan prestasimu.',
                    $finalScore >= 0.6 => 'Tingkatkan atau pertahankan kinerjamu. Kamu memiliki potensi yang bisa lebih berkembang.',
                    default            => 'Tingkatkan kinerjamu, kamu berpotensi menjadi lebih baik dengan usaha yang konsisten.',
                };
            }

            // === Update atau insert final_score_totals per tahun ===
            $existing = DB::table('final_score_totals')
                ->where('alternatif', $alternatif)
                ->where('evaluation_years', $tahun)       // ⬅️ filter tahun
                ->first();

            if ($existing) {
                DB::table('final_score_totals')
                    ->where('id', $existing->id)
                    ->update($payload);
            } else {
                $payload['created_at'] = now();
                DB::table('final_score_totals')->insert($payload);
            }
        }

        // === 8. Gabungkan hasil akhir final_score_totals hanya untuk tahun aktif ($tahun)
        $alternatifList = collect(['t1', 't2', 't3'])
            ->flatMap(function ($stage) use ($tahun) {
                return DB::table("final_score_smart_$stage")
                    ->where('evaluation_years', $tahun)
                    ->pluck('alternatif');
            })
            ->unique()
            ->values();

        foreach ($alternatifList as $alternatif) {
            $scores = [];

            foreach (['t1', 't2', 't3'] as $stage) {
                $smartRow = DB::table("final_score_smart_$stage")
                    ->where('alternatif', $alternatif)
                    ->where('evaluation_years', $tahun)
                    ->first();

                $scores[$stage] = $smartRow
                    ? collect(range(1, 15))->reduce(fn($sum, $i) => $sum + ($smartRow->{"C$i"} ?? 0), 0)
                    : null;
            }

            // Ambil data karyawan yang sesuai dengan alternatif & tahun
            $employee = DB::table('evaluation_employee_data')
                ->where('alternatif', $alternatif)
                ->where('evaluation_years', $tahun)
                ->first();

            if (!$employee) continue;

            $payload = [
                'fullname'         => $employee->fullname,
                'alternatif'       => $alternatif,
                'evaluation_years' => $tahun,
                'score_t1'         => $scores['t1'],
                'score_t2'         => $scores['t2'],
                'score_t3'         => $scores['t3'],
                'updated_at'       => now(),
            ];

            if (collect($scores)->filter()->count() === 3) {
                $finalScore = round(array_sum($scores) / 3, 4);
                $payload['final_score_total'] = $finalScore;
                $payload['information'] = match (true) {
                    $finalScore > 0.8  => 'Selamat, kinerja kamu sangat baik. Pertahankan dan terus tingkatkan prestasimu.',
                    $finalScore >= 0.6 => 'Tingkatkan atau pertahankan kinerjamu. Kamu memiliki potensi yang bisa lebih berkembang.',
                    default            => 'Tingkatkan kinerjamu, kamu berpotensi menjadi lebih baik dengan usaha yang konsisten.',
                };
            }

            // Simpan ke final_score_totals
            $existing = DB::table('final_score_totals')
                ->where('alternatif', $alternatif)
                ->where('evaluation_years', $tahun)
                ->first();

            if ($existing) {
                DB::table('final_score_totals')
                    ->where('id', $existing->id)
                    ->update($payload);
            } else {
                $payload['created_at'] = now();
                DB::table('final_score_totals')->insert($payload);
            }
        }
    }
}
