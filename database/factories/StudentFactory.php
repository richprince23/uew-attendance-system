<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pest\Support\Str;

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
            'other_names' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'index_number' => rand(1000000000, 999999999),
            'email' => $this->faker->unique()->safeEmail,
            'gender' => fake()->randomElement(['male', 'female']),
            'phone' => '0' . rand(20000000, 99999999),
            'department_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'level' => $this->faker->randomElement([100, 200, 300, 400, 500]),
            'group' => $this->faker->randomElement(['Group 1', 'Group 2', 'Group 3', 'Group 4', 'Group 5', 'Group 6', 'Group 7', 'Group 8', 'Group 9', 'Group 10']),
        ];
    }
}
