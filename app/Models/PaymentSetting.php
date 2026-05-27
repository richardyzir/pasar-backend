<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = ['method', 'account_name', 'account_number', 'bank_name', 'va_prefix', 'instructions', 'is_active', 'order'];
}
