<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DepartmentFactory extends Factory
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

    private static $department = [
        'Centre For African Studies',
        'Centre For Conflict, Human Rights and Peace Studies',
        'Department of Economics Education',
        'Department of Geography Education',
        'Department of History Education',
        'Department of Political Science Education',
        'Department of Social Studies Education',
        "Department Agricultural Science Education and Environmental Science",
        "Department of Biology Education",
        "Department of Chemistry Education",
        "Department of Environmental Science Education",
        "Department of Information and Communication Technology",
        "Department of Integrated Science Education",
        "Department of Mathematics Education",
        "Department of Physics Education",
        "Department of Accounting",
        "Department of Applied Finance and Policy Management",
        "Department of Management Sciences",
        "Department of Marketing and Entrepreneurship",
        "Department of Procurement and Supply Chain Management",
        "Department of Akan-Nzema Education",
        "Department of Ewe Education",
        "Department of Ga-Dangme Education",
        "Department of Gur-Gonja Education",
        "Department of Applied Linguistics",
        "Department of English Education",
        "Department of French Education",
        "Department of Art Education",
        "Department of Graphic Design",
        "Department of Music Education",
        "Department of Textiles and Fashion Education",
        "Department of Theatre Arts",
        "Department of Basic Education",
        "Department of Educational Foundations",
        "Department of Educational Management and Administration Education",
        "Department of Clothing and Textiles Education",
        "Department of Environmental Health and Sanitation Education",
        "Department of Family Life Management Education",
        "Department of Food and Nutrition Education",
        "Department of Health Administration Education",
        "Department of Health, Physical Education, Recreation and Sports",
        "Department of Integrated Home Economics Education",
        "Department of Communication Instruction",
        "Department of Development Communication",
        "Department of Journalism and Media Studies",
        "Department of Strategic Communication",
        "Department of Counselling Psychology",
        "Department of Early Grade Education",
        "Department of Special Education"
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(self::$department),
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            // 'faculty' => $this->faker->randomElement(self::$faculty),
            'faculty_id' => $this->faker->randomDigitNotZero(),
            // 'faculty_id' => Faculty::factory(),
            'description' => $this->faker->sentences(3, true),
            'hod' => $this->faker->name()
        ];
    }
}
