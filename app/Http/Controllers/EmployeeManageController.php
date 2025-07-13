<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Departement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use app\Models\User;
use Illuminate\Http\Request;

class EmployeeManageController extends Controller
{
    public function showEmployeeManage(Request $request)
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

        // manggil departement untuk form crete dan update
        $departementEmployee = Departement::where('type', 'employee')->get();

        // fitur search
        $search = $request->input('search');

        $employeeData = User::where('role', 'employee')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', '%' . $search . '%')
                        ->orWhere('gender', 'like', '%' . $search . '%')
                        ->orWhere('departement', 'like', '%' . $search . '%')
                        ->orWhere('workYears', 'like', '%' . $search . '%')
                        ->orWhere('employeementStatus', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('fullname', 'asc')
            ->paginate(10);

        return view('layouts.superadmins.employeeManage', compact('employeeData', 'departementEmployee', 'search', 'userRole', 'users'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|unique:users,fullname',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Pria,Wanita',
            'departement' => 'required|string',
            'workYears' => 'required|string',
            'employeementStatus' => 'required|in:Kontrak,Tetap',
        ]);

        // Ambil nama depan + workYears
        $firstName = Str::of($request->fullname)->explode(' ')->first();
        $usernamePassword = $firstName . $request->workYears;

        // Hitung jumlah user dengan role Employee
        $countEmployee = User::where('role', 'Employee')->count();
        $newAlt = 'A' . ($countEmployee + 1); // Misal sebelumnya 60, maka jadi A61

        // Simpan user
        User::create([
            'fullname'           => $request->fullname,
            'username'           => $usernamePassword,
            'email'              => $request->email,
            'gender'             => $request->gender,
            'departement'        => $request->departement,
            'employeementStatus' => $request->employeementStatus,
            'workYears'          => $request->workYears,
            'role'               => 'Employee',
            'status'             => 'Tidak Aktif',
            'alternatif'         => $newAlt,
            'password'           => Hash::make($usernamePassword),
        ]);

        // Ambil role dari user yang sedang login
        $user = Auth::user();

        // Redirect sesuai role
        if ($user->role === 'superadmin') {
            return redirect()->route('employeeManage.superadmin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Karyawan berhasil ditambahkan.'
            ]);
        } elseif ($user->role === 'admin') {
            return redirect()->route('employeeManage.admin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Karyawan berhasil ditambahkan.'
            ]);
        } else {
            return redirect()->route('dashboard')->with([
                'alert_status' => false,
                'alert_title' => 'Error!',
                'alert_message' => 'Akses tidak dikenali.'
            ]);
        }
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

        $employee = User::findOrFail($id);

        $employee->fullname = $validated['fullname'];
        $employee->gender = $validated['gender'];
        $employee->departement = $validated['departement'];
        $employee->workYears = $validated['workYears'];
        $employee->employeementStatus = $validated['employeementStatus'];

        $employee->save();

        // Ambil role dari user yang sedang login
        $user = Auth::user(); //use Illuminate\Support\Facades\Auth;

        // Redirect sesuai role
        if ($user->role === 'superadmin') {
            return redirect()->route('employeeManage.superadmin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil ditambahkan.'
            ]);
        } elseif ($user->role === 'admin') {
            return redirect()->route('employeeManage.admin')->with([
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
        $user = User::findOrFail($id);
        $user->delete();

        // Ambil role dari user yang sedang login
        $user = Auth::user(); //use Illuminate\Support\Facades\Auth;

        // Redirect sesuai role
        if ($user->role === 'superadmin') {
            return redirect()->route('employeeManage.superadmin')->with([
                'alert_status' => true,
                'alert_title' => 'Success!',
                'alert_message' => 'Data Departemen berhasil ditambahkan.'
            ]);
        } elseif ($user->role === 'admin') {
            return redirect()->route('employeeManage.admin')->with([
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
}
