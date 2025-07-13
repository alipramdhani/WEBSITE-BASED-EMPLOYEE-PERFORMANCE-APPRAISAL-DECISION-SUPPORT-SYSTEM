<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // memanggil 2 seeder sekaligus
        $this->call([
            AuthSeeder::class,
            EmployeeSeeder::class,
            DepartementSeeder::class,
            CriteriaSeeder::class,
            EvaluationEmployeeDataSeeder::class,
            EvaluationT1Seeder::class,
            EvaluationT2Seeder::class,
            EvaluationT3Seeder::class,
            // EvaluationT4Seeder::class,
        ]);

        // memanggil satu satu seeder
        // php artisan db:seed --class=UserSeeder
    }
}
