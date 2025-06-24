<?php

   namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Hoa Hồng',
            'description' => 'Hoa biểu tượng của tình yêu',
        ]);
        Category::create([
            'name' => 'Hoa Cẩm Chướng',
            'description' => 'Hoa tượng trưng cho sự ngưỡng mộ',
        ]);
    }
}