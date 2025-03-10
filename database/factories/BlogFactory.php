<?php

// database/factories/BlogFactory.php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'subTitle' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'user_id' => User::inRandomOrder()->first()->id,  // Rastgele bir kullanıcı seç
        ];
    }
}
