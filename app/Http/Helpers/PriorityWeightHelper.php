<?php

namespace App\Http\Helpers;

use App\Models\Criteria;

class PriorityWeightHelper
{
    public static function recalculateWeights()
    {
        $levelScore = [
            'Biasa' => 1,
            'Penting' => 2,
            'Sangat Penting' => 3,
        ];

        // Ambil kriteria berdasarkan tipe
        $performanceCriterias = Criteria::where('type', 'performance')->get();
        $attitudeCriterias = Criteria::where('type', 'work attitude')->get();

        // Hitung total skor per tipe
        $totalPerformanceScore = $performanceCriterias->sum(function ($criteria) use ($levelScore) {
            return $levelScore[$criteria->priority_level] ?? 0;
        });

        $totalAttitudeScore = $attitudeCriterias->sum(function ($criteria) use ($levelScore) {
            return $levelScore[$criteria->priority_level] ?? 0;
        });

        // Proses untuk tipe Performance (60%)
        foreach ($performanceCriterias as $criteria) {
            $score = $levelScore[$criteria->priority_level] ?? 0;
            $weight = ($totalPerformanceScore > 0) ? ($score / $totalPerformanceScore) * 60 : 0;

            $criteria->priority_weight = number_format($weight, 2);
            $criteria->normalized_weight = $weight / 100;
            $criteria->save();
        }

        // Proses untuk tipe Work Attitude (40%)
        foreach ($attitudeCriterias as $criteria) {
            $score = $levelScore[$criteria->priority_level] ?? 0;
            $weight = ($totalAttitudeScore > 0) ? ($score / $totalAttitudeScore) * 40 : 0;

            $criteria->priority_weight = number_format($weight, 2);
            $criteria->normalized_weight = $weight / 100;
            $criteria->save();
        }
    }
}
