<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->realText(15),
            'slug' => fn(array $attributes) => Str::slug($attributes['title']),
        ];
    }
}
