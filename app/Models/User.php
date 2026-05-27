<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'points',
        'phone_verified_at',
        'is_first_login',
        'permissions',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['permissions' => 'json', 'phone_verified_at' => 'datetime'];

    public function permissions()
    {
        return $this->hasMany(AksesPermission::class);
    }
}
