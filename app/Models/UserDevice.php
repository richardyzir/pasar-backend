<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = ['user_id', 'device_id', 'device_name', 'ip_address', 'user_agent', 'is_verified', 'verified_at'];
    protected $casts = ['is_verified' => 'boolean', 'verified_at' => 'datetime'];

    public static function generateDeviceId($request)
    {
        return md5(implode('|', [$request->ip(), $request->userAgent(), $request->header('X-Device-ID', '')]));
    }
}
