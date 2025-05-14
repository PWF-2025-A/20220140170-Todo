<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Nama kategori akan dibuat secara acak dan unik
            'name' => $this->faker->unique()->word(),

            // Relasi ke user dibuat otomatis lewat factory User
            'user_id' => User::factory(),
        ];
    }
}
