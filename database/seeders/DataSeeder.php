<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Schedules;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Faculty::factory(10)->create();
        Department::factory(49)->create();
        Student::factory(100)->create();
        Lecturer::factory(20)->create();
        Course::factory(10)->create();
        Enrollment::factory(100)->create();
        Schedules::factory(10)->create();
        Attendance::factory(100)->create();
    }
}
