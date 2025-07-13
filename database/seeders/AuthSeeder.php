<?php

namespace Database\Seeders;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authList = [
            [
                'alternatif' => 'A1',
                'username' => 'superadmin123',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('superadmin123'),
                'fullname' => 'Mohamad Alif Ramdani',
                'gender' => 'Pria',
                'departement' => 'IT Team',
                'workYears' => '2023',
                'employeementStatus' => 'Tetap',
                'role' => 'superadmin',
                'status' => 'Aktif',
            ],
            [
                'alternatif' => 'A1',
                'username' => 'admin123',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'fullname' => 'Max Verstappen',
                'gender' => 'Pria',
                'departement' => 'Human Resource',
                'workYears' => '2023',
                'employeementStatus' => 'Tetap',
                'role' => 'admin',
                'status' => 'Aktif',
            ],
        ];
        // Tambah kriteria
        foreach ($authList as $auth) {
            User::create([
                'alternatif' => $auth['alternatif'],
                'username' => $auth['username'],
                'email' => $auth['email'],
                'password' => $auth['password'],
                'fullname' => $auth['fullname'],
                'gender' => $auth['gender'],
                'departement' => $auth['departement'],
                'workYears' => $auth['workYears'],
                'employeementStatus' => $auth['employeementStatus'],
                'role' => $auth['role'],
                'status' => $auth['status'],
            ]);
        }
    }
}
