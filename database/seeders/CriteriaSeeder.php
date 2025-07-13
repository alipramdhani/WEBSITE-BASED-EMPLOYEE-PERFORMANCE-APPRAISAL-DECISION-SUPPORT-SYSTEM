<?php

namespace Database\Seeders;

use App\Http\Helpers\PriorityWeightHelper;
use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteriaList = [
            [
                'code' => 'C1',
                'criteria' => 'Job Knowledge',
                'type' => 'Performance',
                'priority_level' => 'Sangat Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C2',
                'criteria' => 'Quality Of Work',
                'type' => 'Performance',
                'priority_level' => 'Sangat Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C3',
                'criteria' => 'Consistency of Work',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C4',
                'criteria' => 'Stability',
                'type' => 'Performance',
                'priority_level' => 'Biasa',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C5',
                'criteria' => 'Communication',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C6',
                'criteria' => 'Diplomacy & Manners',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C7',
                'criteria' => 'Judgement',
                'type' => 'Performance',
                'priority_level' => 'Biasa',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C8',
                'criteria' => 'Salesmanship',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C9',
                'criteria' => 'Customer Relations',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C10',
                'criteria' => 'Leadership Skill',
                'type' => 'Performance',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C11',
                'criteria' => 'Attitude Towards Supervisors',
                'type' => 'Work Attitude',
                'priority_level' => 'Sangat Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C12',
                'criteria' => 'Attitude Towards Co-Workers',
                'type' => 'Work Attitude',
                'priority_level' => 'Sangat Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C13',
                'criteria' => 'Initiative',
                'type' => 'Work Attitude',
                'priority_level' => 'Penting',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C14',
                'criteria' => 'Attendance',
                'type' => 'Work Attitude',
                'priority_level' => 'Biasa',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
            [
                'code' => 'C15',
                'criteria' => 'Punctuality',
                'type' => 'Work Attitude',
                'priority_level' => 'Biasa',
                'priority_weight' => '',
                'normalized_weight' => '',
            ],
        ];
        // Tambah kriteria
        foreach ($criteriaList as $criteria) {
            Criteria::create([
                'code' => $criteria['code'],
                'criteria' => $criteria['criteria'],
                'type' => $criteria['type'],
                'priority_level' => $criteria['priority_level'],
                'priority_weight' => $criteria['priority_weight'],
                'normalized_weight' => $criteria['normalized_weight'],
            ]);
        }

        // Hitung ulang bobot semua kriteria
        PriorityWeightHelper::recalculateWeights();
    }
}
