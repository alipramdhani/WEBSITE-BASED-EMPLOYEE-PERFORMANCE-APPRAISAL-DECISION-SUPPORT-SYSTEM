<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationEmployeeData extends Model
{
    protected $table = 'evaluation_employee_data';
    protected $fillable = [
        'fullname',
        'alternatif',
        'email',
        'departement',
        'employeementStatus',
        'evaluation_years',
        'evaluation_stage',
        // 'total_score',
    ];
}
