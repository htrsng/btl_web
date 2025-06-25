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
        'requirements', // Đảm bảo thêm dòng này
        'status',
        'delivery_time',
    ];

    // Quan hệ nếu có
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}