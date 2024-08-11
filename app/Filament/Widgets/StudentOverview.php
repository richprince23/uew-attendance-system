<?php

namespace App\Filament\Widgets;

use App\Models\Faculty;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Level 100s', Student::query()->where('level', '100')->count()),
            Stat::make('Total Level 200s', Student::query()->where('level', '200')->count()),
            Stat::make('Total Level 300s', Student::query()->where('level', '300')->count()),
            Stat::make('Total Level 400s', Student::query()->where('level', '400')->count()),
            Stat::make('Total Students', Student::query()->count()),

            // Stat::make('Total Faculties', Faculty::query()->count())
        ];
    }
}
