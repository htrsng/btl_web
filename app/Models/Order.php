<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'phone', 'total', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}