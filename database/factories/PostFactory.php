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
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'sub_title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'status' => 1,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'cover_photo_path' => $this->faker->imageUrl(640, 480, 'posts', true),
            'photo_alt_text' => $this->faker->sentence,
            'user_id' => 1,
        ];
    }
}
