<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = ['phone', 'token', 'type', 'is_verified', 'expires_at', 'verified_at'];
    protected $casts = ['is_verified' => 'boolean', 'expires_at' => 'datetime', 'verified_at' => 'datetime'];

    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }
    public function isValid()
    {
        return !$this->is_verified && !$this->isExpired();
    }
}
