<?php

namespace App\Models;

use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const STATUS_ACTIVE = 'Aktif';
    const STATUS_INACTIVE = 'Tidak Aktif';
    protected $table = 'users';
    protected $fillable = [
        'alternatif',
        'fullname',
        'username',
        'email',
        'password',
        'gender',
        'departement',
        'workYears',
        'employeementStatus',
        'role',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'last_login_at',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
