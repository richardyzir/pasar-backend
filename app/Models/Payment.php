<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'payment_method', 'payment_status', 'amount', 'payment_proof', 'payment_details', 'expires_at', 'paid_at', 'verified_by'];
    protected $casts = ['payment_details' => 'json', 'expires_at' => 'datetime', 'paid_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
