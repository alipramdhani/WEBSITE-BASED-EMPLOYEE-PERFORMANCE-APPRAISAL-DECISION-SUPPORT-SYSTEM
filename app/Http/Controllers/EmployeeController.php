<?php

namespace App\Http\Controllers;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function showLoginForm()
    {
        return view('layouts.employees.employeeLogin');
    }

    public function loginEmployee(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Hanya untuk role "employee"
            if ($user->role === 'employee') {
                if ($user->status === User::STATUS_ACTIVE) {
                    return redirect()->route('dashboard.employee')->with([
                        'alert_status' => true,
                        'alert_title' => 'Login Success!',
                        'alert_message' => 'Selamat Datang Karyawan!',
                    ]);
                } elseif (trim($user->status) === User::STATUS_INACTIVE) {
                    Auth::logout();
                    return redirect()->route('showLogin.employee')->withErrors([
                        'message' => 'Akun belum diaktifkan!',
                    ]);
                }
            } else {
                Auth::logout();
                return redirect()->route('showLogin.employee')->withErrors([
                    'message' => 'Akun tidak diizinkan!',
                ]);
            }
        }
        return redirect()->route('showLogin.employee')->withErrors([
            'message' => 'Username atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLogin.employee');
    }
}
