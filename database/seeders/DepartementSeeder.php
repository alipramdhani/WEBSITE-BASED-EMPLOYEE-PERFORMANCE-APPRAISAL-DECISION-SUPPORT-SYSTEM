<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $departementList = [
            [
                'departement' => 'Human Resource',
                'type' => 'staff',
            ],
            [
                'departement' => 'Housekeeping Supervisor',
                'type' => 'staff',
            ],
            [
                'departement' => 'Marketing',
                'type' => 'staff',
            ],
            [
                'departement' => 'F&B Supervisor',
                'type' => 'staff',
            ],
            [
                'departement' => 'Chief Enginering',
                'type' => 'staff',
            ],
            [
                'departement' => 'Account Receivable',
                'type' => 'staff',
            ],
            [
                'departement' => 'Security',
                'type' => 'employee',
            ],
            [
                'departement' => 'Front Desk Agent',
                'type' => 'employee',
            ],
            [
                'departement' => 'Housekeeping',
                'type' => 'employee',
            ],
            [
                'departement' => 'Sales Admin',
                'type' => 'employee',
            ],

            [
                'departement' => 'F&B Service',
                'type' => 'employee',
            ],

            [
                'departement' => 'F&B Product',
                'type' => 'employee',
            ],

            [
                'departement' => 'Cook',
                'type' => 'employee',
            ],

            [
                'departement' => 'General Maintenance',
                'type' => 'employee',
            ],
        ];
        // Tambah kriteria
        foreach ($departementList as $departement) {
            Departement::create([

                'departement' => $departement['departement'],
                'type' => $departement['type'],

            ]);
        }
    }
}
