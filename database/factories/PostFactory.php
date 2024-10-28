<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => [
                'en' => $this->faker->unique()->realText(30),
                'uk' => $this->faker->unique()->realText(30),
            ],
            'slug' => fn(array $attributes) => Str::slug($attributes['title']['en']),
            'short_description' => [
                'en' => $this->faker->realText(100),
                'uk' => $this->faker->realText(100),
            ],
            'body' => [
                'en' => $this->faker->realText(230),
                'uk' => $this->faker->realText(230),
            ],
            'status' => 1,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'cover_photo_path' => $this->faker->imageUrl(640, 480, 'nature', true, 'Nature Post'),
            'photo_alt_text' => $this->faker->realText(30),
            'user_id' => 1,
            'visible_on_slider' => $this->faker->boolean(20),
        ];
    }
}
