<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */

use App\Models\Category;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 100),
            'title' => ucwords(fake()->sentence()),
            'is_done' => rand(0, 1), // lebih tepat boolean
            'category_id' => Category::inRandomOrder()->first()->id ??
            Category::factory(), 
        ];
    }
}
