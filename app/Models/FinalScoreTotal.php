<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalScoreTotal extends Model
{
    protected $table = 'final_score_totals';
    protected $fillable = [
        'fullname',
        'alternatif',
        'evaluation_years',
        'score_t1',
        'score_t2',
        'score_t3',
        // 'score_t4',
        'final_score_total',
        'keterangan',
    ];
}
