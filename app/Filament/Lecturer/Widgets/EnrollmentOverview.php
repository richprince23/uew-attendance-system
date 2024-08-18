<?php

namespace App\Filament\Lecturer\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EnrollmentOverview extends BaseWidget
{
    protected static ?string $heading = 'Attendance Trend';
    protected function getStats(): array
    {
        $lecturer = Lecturer::where('user_id', auth()->user()->id)->first();

        if (!$lecturer) {
            return [Stat::make('Error', 'Lecturer not found')];
        }

        $courses = Course::where('lecturer_id', $lecturer->id)->get();

        $stats = [];

        foreach ($courses as $course) {
            $enrollmentCount = Enrollment::where('course_id', $course->id)->count();
            $stats[] = Stat::make($course->course_name, $enrollmentCount);
        }

        return $stats;
    }
}
