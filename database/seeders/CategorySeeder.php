<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Teknoloji', 'Oyun', 'Seyahat', 'Yemek'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}

