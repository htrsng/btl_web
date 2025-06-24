<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Thêm cột tên
            $table->string('address'); // Thêm cột địa chỉ
            $table->string('phone'); // Thêm cột số điện thoại
            $table->decimal('total', 10, 2); // Tổng tiền
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};