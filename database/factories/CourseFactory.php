<?php

namespace Database\Factories;

use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_name' => $this->faker->sentence(3),
            'course_code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'semester' => $this->faker->randomElement(['First', 'Second']),
            'lecturer_id' => $this->faker->randomDigitNot(0),
            'level' => $this->faker->randomElement(['100', '200', '300', '400']),
            'year' => $this->faker->year(),
            'department_id' => $this->faker->randomDigitNot(0),
        ];
    }
}
