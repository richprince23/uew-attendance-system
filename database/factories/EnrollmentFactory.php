<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->randomDigitNot(0),
            'course_id' => $this->faker->randomDigitNot(0),
            'year' => $this->faker->year(),
            'semester' => $this->faker->randomElement(['First', 'Second']),
        ];
    }
}
