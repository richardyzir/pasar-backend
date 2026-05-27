<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'kurir_id',
        'total_amount',
        'shipping_address',
        'delivery_time',
        'delivery_note',
        // 'addon',
        // 'addon_fee',
        'admin_fee',
        'status',
        'payment_method',
        'payment_status',
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class)->with('product');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public static function generateOrderNumber()
    {
        return 'ORD' . date('Ymd') . strtoupper(substr(uniqid(), -5));
    }
}
