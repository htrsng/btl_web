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
            'name' => 'Hoa Tulip',
            'description' => 'Hoa biểu tượng của sự thanh lịch',
        ]);
        Category::create([
            'name' => 'Hoa Cẩm Tú Cầu',
            'description' => 'Hoa biểu tượng của sự chân thành',
        ]);
        Category::create([
            'name' => 'Hoa Sen',
            'description' => 'Hoa biểu tượng của sự thanh khiết',
        ]);
        Category::create([
            'name' => 'Hoa Hương Dương',
            'description' => 'Hoa biểu tượng của sự tươi sáng',
        ]);
    }
}