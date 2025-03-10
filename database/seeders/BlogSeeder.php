<?php

// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // 10 adet fake blog verisi oluştur
        Blog::factory(25)->create();
    }
}
