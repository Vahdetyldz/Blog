<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $blogs = Blog::all();

        foreach ($blogs as $blog) {
            foreach (range(1, rand(2, 5)) as $i) {
                Comment::create([
                    'blog_id' => $blog->id,
                    'user_id' => $users->random()->id,
                    'comment' => fake()->sentence(8),
                ]);
            }
        }
    }
}
