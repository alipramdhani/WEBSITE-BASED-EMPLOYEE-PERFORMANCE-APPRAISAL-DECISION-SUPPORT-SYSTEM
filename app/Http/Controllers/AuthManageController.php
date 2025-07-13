<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use app\Models\User;
use Illuminate\Http\Request;

class AuthManageController extends Controller
{
    public function showAuthManage(Request $request)
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

        $adminUsers = User::where('role', 'admin')->get();
        $search = $request->input('search');

        $employeeUsers = User::where('role', 'employee')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('fullname', 'asc')
            ->paginate(10);

        return view('layouts.superadmins.authManage', compact('adminUsers', 'employeeUsers', 'search', 'userRole', 'users'));
    }

    public function updateAuthManage(Request $request)
    {
        $userId = $request->input('id');

        // Validasi data input
        $validated = $request->validate([
            'id'       => 'required|exists:users,id',
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
            'status'   => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Ambil user dari database
        $user = User::findOrFail($userId);

        // Update data user
        $user->username = $validated['username'];
        $user->email    = $validated['email'];
        $user->status   = $validated['status'];

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->back()->with([
            'alert_status' => true,
            'alert_title' => 'Update Success!',
            'alert_message' => 'Autentikasi berhasil perbaharui.'
        ]);
    }
}
