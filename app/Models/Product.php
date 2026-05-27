<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'base_price',
        'packing_fee',
        'kurir_fee',
        'stock',
        'image',
        'category',
        'stock',
        'unit',
        'is_active'
    ];
}
