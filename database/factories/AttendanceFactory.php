<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
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
            // 'enrollment_id'=> $this->faker->randomDigitNot(0),
            'schedule_id' => $this->faker->randomDigitNot(0),
            'status' => $this->faker->randomElement(['Present', 'Absent', 'Late', 'Excused', 'Sick']),
            'date' => $this->faker->date(),
            'time_in' => $this->faker->time(),
        ];
    }
}
