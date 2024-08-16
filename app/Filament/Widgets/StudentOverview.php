<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::query()->count()),
            Stat::make('Total Lecturers', Lecturer::query()->count()),
            Stat::make('Total Faculties', Faculty::query()->count()),
            Stat::make('Total Departments', Department::query()->count()),

            // Stat::make('Total Faculties', Faculty::query()->count())
        ];
    }
}
