<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PriorityWeightHelper;
use App\Models\Criteria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CriteriaManageController extends Controller
{
    public function showCriteriaManage(Request $request)
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

        $search = $request->input('search');

        $criteriaP = Criteria::where('type', 'Performance')->get();
        $criteriaWA = Criteria::where('type', 'Work Attitude')->get();
        $criteriaData = Criteria::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhere('criteria', 'like', '%' . $search . '%')
                        ->orWhere('type', 'like', '%' . $search . '%')
                        ->orWhere('priority_level', 'like', '%' . $search . '%')
                        ->orWhere('priority_weight', 'like', '%' . $search . '%')
                        ->orWhere('normalized_weight', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('layouts.superadmins.criteriaManage', compact('criteriaData', 'criteriaP', 'criteriaWA', 'userRole', 'users'));
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:criterias,code',
            'criteria' => 'required|string',
            'type' => 'required|string',
            'priority_level' => 'required|in:Biasa,Penting,Sangat Penting',
        ]);

        Criteria::create($validated);

        // Hitung ulang semua bobot
        PriorityWeightHelper::recalculateWeights();

        $user = Auth::user();
        $redirectRoute = match ($user->role) {
            'superadmin' => 'criteriaManage.superadmin',
            'admin' => 'criteriaManage.admin',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute)->with([
            'alert_status' => true,
            'alert_title' => 'Success!',
            'alert_message' => 'Kriteria berhasil Ditambahkan & bobot dihitung ulang!'
        ]);
    }

    public function delete($id)
    {
        $criteria = Criteria::find($id);

        if (!$criteria) {
            return back()->with([
                'alert_status' => false,
                'alert_title' => 'Gagal!',
                'alert_message' => 'kriteria tidak ditemukan.'
            ]);
        }

        $criteria->delete();

        // Hitung ulang bobot setelah penghapusan
        PriorityWeightHelper::recalculateWeights();

        $user = Auth::user();

        $redirectRoute = match ($user->role) {
            'superadmin' => 'criteriaManage.superadmin',
            'admin' => 'criteriaManage.admin',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute)->with([
            'alert_status' => true,
            'alert_title' => 'Success!',
            'alert_message' => 'Kriteria berhasil dihapus & bobot dihitung ulang!'
        ]);
    }
}
