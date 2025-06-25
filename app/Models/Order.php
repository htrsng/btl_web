<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'phone', 'total', 'status', 'delivery_time'];

    protected $casts = [
        'delivery_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}