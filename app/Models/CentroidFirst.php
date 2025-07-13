<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroidFirst extends Model
{
    protected $table = 'centroid_first';
    protected $fillable = [
        'evaluation_years',
        'selected',
        'centroid',
        'final_score_total',
        'status',
    ];
}
