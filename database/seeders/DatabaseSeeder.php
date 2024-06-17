<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Lecturer;
use App\Models\Schedules;
use App\Models\Student;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@user.com',
            'password' => bcrypt('password'),
        ]);
        Department::factory(10)->create();
        Student::factory(100)->create();
        Lecturer::factory(20)->create();
        Course::factory(20)->create();
        Enrollment::factory(100)->create();
        Schedules::factory(100)->create();
        Attendance::factory(100)->create();
    }
}
