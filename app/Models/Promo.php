<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['title', 'description', 'image', 'bg_color', 'text_color', 'order', 'is_active'];
}
