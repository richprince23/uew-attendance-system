<?php

namespace App\Filament\Lecturer\Widgets;

use App\Models\Lecturer;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();
        $lecturerId = $lecturer->id ?? 0;
        return [
            Stat::make('Total Level 100s', Student::query()->where('students.level', '100')
            ->join('enrollments', 'students.id','enrollments.student_id')
            ->join('courses', 'enrollments.course_id','courses.id')
            ->join('lecturers', 'courses.lecturer_id','enrollments.course_id')
            ->where('courses.lecturer_id', $lecturerId)->count()),

            Stat::make('Total Level 200s', Student::query()->where('students.level', '200')
            ->join('enrollments', 'students.id','enrollments.student_id')
            ->join('courses', 'enrollments.course_id','courses.id')
            ->join('lecturers', 'courses.lecturer_id','enrollments.course_id')
            ->where('courses.lecturer_id', $lecturerId)->count()),

            Stat::make('Total Level 300s', Student::query()->where('students.level', '300')
            ->join('enrollments', 'students.id','enrollments.student_id')
            ->join('courses', 'enrollments.course_id','courses.id')
            ->join('lecturers', 'courses.lecturer_id','enrollments.course_id')
            ->where('courses.lecturer_id', $lecturerId)->count()),

            Stat::make('Total Level 400s', Student::query()->where('students.level', '400')
            ->join('enrollments', 'students.id','enrollments.student_id')
            ->join('courses', 'enrollments.course_id','courses.id')
            ->join('lecturers', 'courses.lecturer_id','enrollments.course_id')
            ->where('courses.lecturer_id', $lecturerId)->count()),
        ];
    }
}
