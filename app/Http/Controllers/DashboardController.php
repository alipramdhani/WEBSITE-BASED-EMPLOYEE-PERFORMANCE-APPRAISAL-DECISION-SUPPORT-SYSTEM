<?php

namespace App\Http\Controllers;

use App\Models\ClusteringResult;
use App\Models\User;
use App\Models\FinalScoreTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showAdminDashboard(Request $request)
    {
        // Ringkasan dashboard
        $jumlahKaryawan = User::where('role', 'employee')->count();
        $akunAktif = User::where('status', 'Aktif')->count();
        $skorSmartTertinggi = FinalScoreTotal::orderByDesc('final_score_total')->first();
        $skorKmeansTertinggi = ClusteringResult::orderByDesc('closest_distance')->first();

        // Tahap grafik evaluasi
        $tahap = $request->get('tahap', 't1');
        $table = "evaluations_$tahap";

        // Ambil nama dari final_score_totals untuk pemetaan fullname
        $users = FinalScoreTotal::select('alternatif', 'fullname')->get()->keyBy('alternatif');

        // Ambil data evaluasi dan paginasi
        $evaluasiQuery = DB::table($table);
        $evaluasi = $evaluasiQuery->paginate(10); // misal 10 per halaman

        // Transformasi hasil paginasi (items())
        $transformedItems = $evaluasi->getCollection()->transform(function ($item) use ($users) {
            $item->fullname = $users[$item->alternatif]->fullname ?? $item->alternatif;
            return $item;
        });

        // Set kembali hasil transformasi ke paginator
        $evaluasi->setCollection($transformedItems);

        return view('layouts.admins.dashboard', compact(
            'jumlahKaryawan',
            'akunAktif',
            'skorSmartTertinggi',
            'skorKmeansTertinggi',
            'evaluasi',
            'tahap'
        ));
    }
    public function showSuperAdminDashboard(Request $request)
    {
        // Ringkasan dashboard
        $jumlahKaryawan = User::where('role', 'employee')->count();
        $akunAktif = User::where('status', 'Aktif')->count();
        $skorSmartTertinggi = FinalScoreTotal::orderByDesc('final_score_total')->first();
        $skorKmeansTertinggi = ClusteringResult::orderByDesc('closest_distance')->first();

        // Tahap grafik evaluasi
        $tahap = $request->get('tahap', 't1');
        $table = "evaluations_$tahap";

        // Ambil nama dari final_score_totals untuk pemetaan fullname
        $users = FinalScoreTotal::select('alternatif', 'fullname')->get()->keyBy('alternatif');

        // Ambil data evaluasi dan paginasi
        $evaluasiQuery = DB::table($table);
        $evaluasi = $evaluasiQuery->paginate(10); // misal 10 per halaman

        // Transformasi hasil paginasi (items())
        $transformedItems = $evaluasi->getCollection()->transform(function ($item) use ($users) {
            $item->fullname = $users[$item->alternatif]->fullname ?? $item->alternatif;
            return $item;
        });

        // Set kembali hasil transformasi ke paginator
        $evaluasi->setCollection($transformedItems);

        return view('layouts.superadmins.dashboard', compact(
            'jumlahKaryawan',
            'akunAktif',
            'skorSmartTertinggi',
            'skorKmeansTertinggi',
            'evaluasi',
            'tahap'
        ));
    }
}
