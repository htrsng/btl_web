<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'total',
        'requirements',
        'status',
        'delivery_time',
        'admin_reply',
    ];

    // Quan hệ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cast delivery_time thành datetime
    protected $casts = [
        'delivery_time' => 'datetime',
    ];
}