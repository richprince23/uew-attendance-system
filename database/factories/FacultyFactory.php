<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    private static $faculty = [
        'Faculty of Social Sciences Education',
        'Faculty of Science Education',
        'School of Creative Arts',
        'School of Business',
        'Faculty of Ghanaian Languages Education',
        'Faculty of Foreign Languages Education',
        'School of Education and Life-Long Learning',
        'Faculty of Health, Allied Sciences and Home Economics Education',
        'School of Communication and Media Studies',
        'Faculty of Applied Behavioural Sciences in Education'
    ];


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(self::$faculty),
            'dean' => $this->faker->name,
        ];
    }
}
