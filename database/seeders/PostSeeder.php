<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(10)->create();

        $tags = Tag::factory(10)->create();

        Post::factory(20)->create()->each(function ($post) use ($categories, $tags) {
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
            $post->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
