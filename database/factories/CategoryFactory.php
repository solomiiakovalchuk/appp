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
            'name' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'description' => $this->faker->sentence,
            'is_active' => true,
            'show_in_menu' => $this->faker->boolean,
        ];
    }
}
