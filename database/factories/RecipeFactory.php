<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'title'         => $this->faker->sentence(3),
            'calories'      => $this->faker->numberBetween(200, 900),
            'protein_g'     => $this->faker->randomFloat(1, 5, 60),
            'carbs_g'       => $this->faker->randomFloat(1, 5, 120),
            'fat_g'         => $this->faker->randomFloat(1, 2, 80),
            'fiber_g'       => $this->faker->randomFloat(1, 1, 30),
            'carbon_grams'  => $this->faker->numberBetween(50, 800),
            'instructions'  => $this->faker->paragraph(),
        ];
    }
}
