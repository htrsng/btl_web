<?php

   namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1, // ID của user từ UserSeeder
            'name' => 'Nguyen Van A',
            'address' => '123 Duong Hoa, Ha Noi',
            'phone' => '0905123456',
            'total' => 150000,
            'status' => 'pending',
        ]);
    }
}