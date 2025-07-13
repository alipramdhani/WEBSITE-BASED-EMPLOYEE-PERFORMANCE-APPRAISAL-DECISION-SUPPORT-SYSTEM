<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('layouts.authLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $user->last_login_at = now();
            $user->save();

            // Simpan data user di session
            session([
                'user_id' => $user->id,
                'fullname' => $user->fullname,
                'role' => $user->role,
                'status' => $user->status,
            ]);

            // Arahkan berdasarkan peran
            if ($user->role === 'superadmin') {
                return redirect()->route('dashboard.superadmin')->with([
                    'alert_status' => true,
                    'alert_title' => 'Login Success!',
                    'alert_message' => 'Selamat Datang Admin!'
                ]);
            } elseif ($user->role === 'admin') {
                if ($user->status === 'Aktif') {
                    return redirect()->route('dashboard.admin')->with([
                        'alert_status' => true,
                        'alert_title' => 'Login Success!',
                        'alert_message' => 'Selamat Datang Admin!'
                    ]);
                } else {
                    Auth::logout();
                    return redirect()->route('showLogin')->withErrors(['email' => 'Akun belum diaktifkan!']);
                }
            } else {
                Auth::logout();
                return redirect()->route('showLogin')->withErrors(['email' => 'Akun tidak diizinkan.']);
            }
        }

        return back()->withErrors(['email' => 'Username atau password salah']);
    }



    public function logout(Request $request)
    {
        // Ambil role sebelum logout
        $role = Auth::user()->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan sesuai role
        if ($role === 'employee') {
            return redirect('/karyawan');
        }

        return redirect('/'); // untuk admin & superadmin
    }
}
