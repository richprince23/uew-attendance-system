<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EnrollmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Enrollments', Enrollment::query()->count()),
            Stat::make('Total Level 100s', Enrollment::with('course.lecturer') // Eager load related models
            ->whereHas('course', function ($query) {
                $query->where('lecturer_id', 2);
            })->count()),
            // Stat::make('Total Level 200s', Enrollment::query()->where('level', '200')->count()),
            // Stat::make('Total Level 300s', Enrollment::query()->where('level', '300')->count()),
            // Stat::make('Total Level 400s', Enrollment::query()->where('level', '400')->count()),
        ];
    }
}
