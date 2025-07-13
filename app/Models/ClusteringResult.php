<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClusteringResult extends Model
{
    protected $table = 'clustering_result';
    protected $fillable = [
        'fullname',
        'evaluation_years',
        'final_score_total',
        'distance_c1',
        'distance_c2',
        'distance_c3',
        'closest_distance',
        'cluster',
    ];
}
