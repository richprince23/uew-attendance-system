<?php

namespace App\Filament\Student\Widgets;

use App\Models\Enrollment;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStat extends BaseWidget
{
    protected function getStats(): array
    {
        $student = Student::where('user_id', auth()->id())->get()->first();
        $studentId = $student->id;

        return [
            Stat::make('Enrolled Courses', Enrollment::query()->where('student_id', $studentId)->count())
        ];
    }
}
