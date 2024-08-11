<?php

namespace App\Filament\Lecturer\Widgets;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Level 400s', Student::query()->where('level', '400')->count()),
            Stat::make('Total Level 400s', Student::query()->where('level', '400')->count()),
        ];
    }
}
