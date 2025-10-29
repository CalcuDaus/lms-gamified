<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material_id' => \App\Models\Material::factory(),
            'title' => fake()->sentence(),
            'xp_reward' => fake()->numberBetween(50, 200),
            'time_limit' => fake()->numberBetween(5, 60), // in minutes
            'passing_score' => fake()->numberBetween(70, 100),
        ];
    }
}
