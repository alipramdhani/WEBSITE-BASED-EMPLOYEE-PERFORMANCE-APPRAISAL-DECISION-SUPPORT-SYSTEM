<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';
    protected $fillable = [
        'code',
        'criteria',
        'type',
        'priority_level',
        'priority_weight',
        'normalized_weight',
    ];
}
