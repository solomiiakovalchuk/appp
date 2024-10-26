<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->realText(15),
            'slug' => fn(array $attributes) => Str::slug($attributes['title']),
            'description' => $this->faker->realText(90),
            'is_active' => true,
            'show_in_menu' => $this->faker->boolean,
        ];
    }
}
