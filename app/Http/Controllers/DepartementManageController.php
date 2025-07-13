<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;

class DepartementManageController extends Controller
{
    public function showDepartementManage()
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

        $departements = Departement::all();
        return view('layouts.superadmins.departementManage', compact('departements', 'userRole'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'departement' => 'required|string|unique:departements,departement',
            'type' => 'required|string|max:20',
        ]);

        Departement::create([
            'departement' => $request->departement,
            'type' => $request->type,
        ]);

        // Ambil role dari user yang sedang login
        $user = Auth::user();

        // Redirect sesuai role
        if ($user->role === 'superadmin') {
            return redirect()->route('departementManage.superadmin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil ditambahkan.'
            ]);
        } elseif ($user->role === 'admin') {
            return redirect()->route('departementManage.admin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil ditambahkan.'
            ]);
        } else {
            // Default redirect kalau role tidak dikenali
            return redirect()->route('dashboard')->with([
                'alert_status' => false,
                'alert_title' => 'Error!',
                'alert_message' => 'Akses tidak dikenali.'
            ]);
        }
    }

    public function delete($id)
    {
        $departements = Departement::findOrFail($id);
        $departements->delete();

        $user = Auth::user();

        // Redirect sesuai role
        if ($user->role === 'superadmin') {
            return redirect()->route('departementManage.superadmin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil dihapus.'
            ]);
        } elseif ($user->role === 'admin') {
            return redirect()->route('departementManage.admin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil dihapus.'
            ]);
        } else {
            // Default redirect kalau role tidak dikenali
            return redirect()->route('dashboard')->with([
                'alert_status' => false,
                'alert_title' => 'Error!',
                'alert_message' => 'Akses tidak dikenali.'
            ]);
        }
    }
}
