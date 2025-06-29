<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration {
       public function up()
       {
           Schema::create('products', function (Blueprint $table) {
               $table->id();
               $table->string('name');
               $table->decimal('price', 8, 2);
               $table->integer('stock');
               $table->string('image')->nullable();
               $table->unsignedBigInteger('category_id');
               $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
               $table->timestamps();
           });
       }

       public function down()
       {
           Schema::dropIfExists('products');
       }
   };