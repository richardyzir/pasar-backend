<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesPermission extends Model
{
    protected $fillable = ['user_id', 'module', 'can_view', 'can_create', 'can_edit', 'can_delete'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}