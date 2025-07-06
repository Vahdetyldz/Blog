<?php

// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $categories = Category::all();

        foreach (range(1, 10) as $i) {
            Blog::create([
                'title' => 'Blog Başlığı ' . $i,
                'subtitle' => 'Alt başlık ' . $i,
                'content' => fake()->paragraph(5),
                'image' => null,
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}

