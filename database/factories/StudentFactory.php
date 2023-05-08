<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::factory(['age' => fake()->numberBetween(18, 26)]),
            'department_id' => fake()->numberBetween(1, 6),
            'level' => fake()->numberBetween(1, 4),
            'courses' => json_encode([])
        ];

    }
}
