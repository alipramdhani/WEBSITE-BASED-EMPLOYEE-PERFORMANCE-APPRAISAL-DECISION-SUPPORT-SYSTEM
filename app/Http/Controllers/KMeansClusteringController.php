<?php

namespace App\Http\Controllers;

use App\Models\FinalScoreTotal;
use App\Models\CentroidFirst;
use App\Models\ClusteringResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KMeansClusteringController extends Controller
{
    public function showBestPerformance(Request $request)
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
        $search = $request->input('search');

        $finalScoreTotal = DB::table('final_score_totals')
            ->when($search, fn($q) => $q->where('fullname', 'like', "%$search%"))
            ->where('evaluation_years', $tahun)
            ->paginate(10); // 10 data per halaman


        // Highlighting: cek nama yang dicari
        $highlightedNames = collect();
        if ($search) {
            $highlightedNames = $finalScoreTotal->filter(function ($item) use ($search) {
                return stripos($item->fullname, $search) !== false;
            })->pluck('fullname');
        }

        $centroidFirst = CentroidFirst::where('evaluation_years', $tahun)
            ->where('status', 'Awal')
            ->get();
        $kmeansResult = ClusteringResult::where('evaluation_years', $tahun)
            ->orderBy('cluster', 'asc')
            ->get();

        $highlightedClusters = collect();
        if ($search) {
            $highlightedClusters = $kmeansResult->filter(function ($item) use ($search) {
                return stripos($item->fullname, $search) !== false;
            })->pluck('fullname');
        }

        $cluster1 = $kmeansResult->where('cluster', 'C1');
        $cluster2 = $kmeansResult->where('cluster', 'C2');
        $cluster3 = $kmeansResult->where('cluster', 'C3');

        return view('layouts.admins.bestPerformance', compact(
            'finalScoreTotal',
            'tahun',
            'centroidFirst',
            'kmeansResult',
            'cluster1',
            'cluster2',
            'cluster3',
            'highlightedNames',
            'search',
            'userRole',
            'users'
        ));
    }



    public function generateCentroid(Request $request)
    {
        // Validasi input tahun
        $request->validate([
            'evaluation_years' => 'required|digits:4',
        ]);

        $tahun = $request->input('evaluation_years');

        // Ambil semua skor untuk tahun tertentu
        $scores = FinalScoreTotal::where('evaluation_years', $tahun)
            ->whereNotNull('final_score_total')
            ->orderBy('final_score_total', 'asc')
            ->get();

        // Validasi minimal 3 data
        if ($scores->count() < 3) {
            return back()->with('error', 'Data tidak cukup untuk menentukan centroid.');
        }

        // Ambil data min, median, max
        $min = $scores->first();
        $max = $scores->last();

        $count = $scores->count();
        $medianIndex = $count % 2 === 0
            ? intval($count / 2) - 1
            : floor($count / 2);

        $median = $scores[$medianIndex];

        // Hapus centroid 'Awal' yang sudah ada
        CentroidFirst::where('evaluation_years', $tahun)
            ->where('status', 'Awal')
            ->delete();

        // Simpan centroid C1 (max) - tertinggi
        CentroidFirst::create([
            'evaluation_years'  => $tahun,
            'selected'          => $max->fullname,
            'centroid'          => 'C1',
            'final_score_total' => $max->final_score_total,
            'status'            => 'Awal',
        ]);

        // Simpan centroid C2 (median)
        CentroidFirst::create([
            'evaluation_years'  => $tahun,
            'selected'          => $median->fullname,
            'centroid'          => 'C2',
            'final_score_total' => $median->final_score_total,
            'status'            => 'Awal',
        ]);

        // Simpan centroid C3 (min) - terendah
        CentroidFirst::create([
            'evaluation_years'  => $tahun,
            'selected'          => $min->fullname,
            'centroid'          => 'C3',
            'final_score_total' => $min->final_score_total,
            'status'            => 'Awal',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('bestPerformance.superadmin')->with('success', 'Centroid berhasil digenerate!');
    }

    public function generateKMeans($year)
    {
        // 1. Ambil data skor final berdasarkan tahun
        $data = FinalScoreTotal::where('evaluation_years', $year)
            ->whereNotNull('final_score_total')
            ->get();

        if ($data->count() < 3) {
            return back()->with('error', 'Data tidak cukup untuk melakukan clustering.');
        }

        // 2. Ambil centroid awal berdasarkan tahun (status: Awal)
        $centroids = CentroidFirst::where('evaluation_years', $year)
            ->where('status', 'Awal')
            ->get()
            ->keyBy('centroid');

        if ($centroids->isEmpty() || $centroids->count() < 3) {
            return back()->with([
                'alert_status' => false,
                'alert_title' => 'Processing Failed!',
                'alert_message' => 'Silakan generate centroid awal terlebih dahulu.',
            ]);
        }

        // 3. Inisialisasi loop K-Means
        $clusterMap = [];
        $changed = true;

        while ($changed) {
            $newClusterMap = [];

            // 3a. Hitung jarak ke tiap centroid untuk setiap data
            foreach ($data as $item) {
                $score = $item->final_score_total;

                $distance1 = sqrt(pow($centroids['C1']->final_score_total - $score, 2));
                $distance2 = sqrt(pow($centroids['C2']->final_score_total - $score, 2));
                $distance3 = sqrt(pow($centroids['C3']->final_score_total - $score, 2));

                $distances = [
                    'C1' => $distance1,
                    'C2' => $distance2,
                    'C3' => $distance3,
                ];

                // 3b. Tentukan cluster terdekat
                $closestCluster = array_keys($distances, min($distances))[0];
                $newClusterMap[$item->id] = $closestCluster;
            }

            // 3c. Cek apakah ada perubahan cluster
            $changed = $newClusterMap !== $clusterMap;
            $clusterMap = $newClusterMap;

            // 3d. Kelompokkan data berdasarkan cluster
            $clusters = ['C1' => [], 'C2' => [], 'C3' => []];
            foreach ($data as $item) {
                $cluster = $clusterMap[$item->id];
                $clusters[$cluster][] = $item->final_score_total;
            }

            // 3e. Update centroid berdasarkan rata-rata skor dalam cluster
            foreach ($clusters as $label => $values) {
                if (count($values)) {
                    $centroids[$label]->final_score_total = array_sum($values) / count($values);
                }
            }
        }

        // 4. Hapus hasil clustering sebelumnya untuk tahun ini
        ClusteringResult::where('evaluation_years', $year)->delete();

        // 5. Simpan hasil clustering akhir
        foreach ($data as $item) {
            $score = $item->final_score_total;

            $distance1 = sqrt(pow($centroids['C1']->final_score_total - $score, 2));
            $distance2 = sqrt(pow($centroids['C2']->final_score_total - $score, 2));
            $distance3 = sqrt(pow($centroids['C3']->final_score_total - $score, 2));

            $distances = [
                'C1' => $distance1,
                'C2' => $distance2,
                'C3' => $distance3,
            ];

            $closestDistance = min($distances);
            $cluster = array_keys($distances, $closestDistance)[0];

            ClusteringResult::create([
                'fullname'          => $item->fullname,
                'evaluation_years'  => $year,
                'final_score_total' => $score,
                'distance_c1'       => $distance1,
                'distance_c2'       => $distance2,
                'distance_c3'       => $distance3,
                'closest_distance'  => $closestDistance,
                'cluster'           => $cluster,
            ]);
        }

        // 6. Simpan centroid akhir ke tabel centroid_first
        CentroidFirst::where('evaluation_years', $year)
            ->where('status', 'Akhir')
            ->delete(); // hapus sebelumnya jika ada

        foreach (['C1', 'C2', 'C3'] as $label) {
            CentroidFirst::create([
                'evaluation_years'  => $year,
                'selected'          => '-', // tidak relevan untuk centroid hasil iterasi
                'centroid'          => $label,
                'final_score_total' => $centroids[$label]->final_score_total,
                'status'            => 'Akhir',
            ]);
        }

        // 7. Redirect dengan notifikasi sukses
        return redirect()->route('bestPerformance.superadmin')->with([
            'alert_status' => true,
            'alert_title' => 'Clustering Success!',
            'alert_message' => 'Clustering berhasil dilakukan dan centroid akhir telah disimpan!',
        ]);
    }

    public function resetClustering($evaluation_years)
    {
        // Hapus berdasarkan evaluation_years
        DB::table('centroid_first')->where('evaluation_years', $evaluation_years)->delete();
        DB::table('clustering_result')->where('evaluation_years', $evaluation_years)->delete();

        return redirect()->back()->with('success', 'Data clustering berhasil direset.');
    }
}
