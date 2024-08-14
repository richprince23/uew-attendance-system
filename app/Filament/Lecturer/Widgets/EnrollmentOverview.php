<?php

namespace App\Filament\Lecturer\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EnrollmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();
        $lecturerId = $lecturer->id ?? 0;
        $courses = Course::query()->where('lecturer_id','=', $lecturerId)->get()->pluck('course_name');
        $stats = [];

        foreach ($courses as $course) {
            array_push($stats,  Stat::make($course, Enrollment::with('course.lecturer.student') // Eager load related models
            ->whereHas('course', function ($query) {
                $query->where('lecturer_id', Lecturer::where('user_id', auth()->user()->id)->get()->first()->pluck('id'));
            })->count()),);
        }
        return
            // Stat::make('Total Enrollments', Enrollment::query()->count()),


            $stats;
            // Stat::make('Total Level 200s', Enrollment::query()->where('level', '200')->count()),
            // Stat::make('Total Level 300s', Enrollment::query()->where('level', '300')->count()),
            // Stat::make('Total Level 400s', Enrollment::query()->where('level', '400')->count()),
        // ];
    }
}
