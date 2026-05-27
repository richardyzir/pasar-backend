<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginStamp extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'login_at', 'logout_at'];
    public $timestamps = false;
}
