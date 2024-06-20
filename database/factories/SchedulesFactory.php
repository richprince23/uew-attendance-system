<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedules>
 */
class SchedulesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'course_id' => $this->faker->randomDigitNot(0),
            'course_id' => Course::factory(),
            'lecturer_id' => $this->faker->randomDigitNot(0),
            'venue' => $this->faker->sentence(3),
            'room'=> $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
            'day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
        ];
    }
}
