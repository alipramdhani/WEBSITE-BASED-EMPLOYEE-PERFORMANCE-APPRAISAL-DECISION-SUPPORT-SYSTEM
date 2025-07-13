<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminManageController extends Controller
{

    public function showAdminManage()
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

        $departementStaff = Departement::where('type', 'staff')->get();
        $adminData = User::where('role', 'admin')->get();
        return view('layouts.superadmins.adminManage', compact('adminData', 'departementStaff', 'userRole', 'users'));
    }


    public function create(Request $request)
    {
        $request->validate([
            'fullname'           => 'required|string|unique:users,fullname',
            'email'              => 'required|email|unique:users,email',
            'gender'             => 'required|in:Pria,Wanita',
            'departement'        => 'required|string',
            'employeementStatus' => 'required|in:Kontrak,Tetap',
            'workYears'          => 'required|string',
        ]);

        // Ambil nama depan + workYears
        $firstName = Str::of($request->fullname)->explode(' ')->first();
        $usernamePassword = Str::ucfirst($firstName) . $request->workYears;

        // Hitung jumlah user dengan role Admin
        $countAdmin = User::where('role', 'admin')->count();
        $newAlt = 'A' . ($countAdmin + 1); // Contoh: admin ke-4 => A4

        // Simpan user admin
        User::create([
            'fullname'           => $request->fullname,
            'username'           => $usernamePassword,
            'email'              => $request->email,
            'gender'             => $request->gender,
            'departement'        => $request->departement,
            'employeementStatus' => $request->employeementStatus,
            'workYears'          => $request->workYears,
            'role'               => 'admin',
            'status'             => 'Aktif',
            'alternatif'         => $newAlt,
            'password'           => Hash::make($usernamePassword),
        ]);

        return redirect()->route('adminManage.superadmin')->with([
            'alert_status'  => true,
            'alert_title'   => 'Success!',
            'alert_message' => 'Admin berhasil ditambahkan.'
        ]);
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|unique:users,fullname,' . $id,
            'gender' => 'required|in:Pria,Wanita',
            'departement' => 'required|string',
            'workYears' => 'required|integer',
            'employeementStatus' => 'required|in:Kontrak,Tetap',
        ]);

        $admin = User::findOrFail($id);

        $admin->fullname = $validated['fullname'];
        $admin->gender = $validated['gender'];
        $admin->departement = $validated['departement'];
        $admin->workYears = $validated['workYears'];
        $admin->employeementStatus = $validated['employeementStatus'];

        $admin->save();

        return redirect()->back()->with([
            'alert_status' => true,
            'alert_title' => 'Update Success!',
            'alert_message' => 'Admin berhasil diubah.'
        ]);
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with([
            'alert_status' => true,
            'alert_type' => 'success',
            'alert_title' => 'Delete Success!',
            'alert_message' => 'Data berhasil dihapus.'
        ]);
    }
}
