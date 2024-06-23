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

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@user.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'Test Lecturer',
            'email' => 'lecturer@user.com',
            'role' => 'lecturer',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@user.com',
            'role' => 'student',
            'password' => bcrypt('password'),
        ]);

        // User::factory(10)->create();
        Faculty::factory(10)->create();
        Department::factory(49)->create();
        // Student::factory(100)->create();
        // Lecturer::factory(20)->create();
        // Course::factory(10)->create();
        // Enrollment::factory(100)->create();
        // Schedules::factory(10)->create();
        // Attendance::factory(100)->create();
    }
}
