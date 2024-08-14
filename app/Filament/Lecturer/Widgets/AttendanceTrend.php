<?php

namespace App\Filament\Lecturer\Widgets;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lecturer;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendanceTrend extends ChartWidget
{
    protected static ?string $heading = 'Attendance Trend';
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
{
    $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();

    $lecturerId = $lecturer->id ?? 0;

    $lecturerCourseIds = Course::where('lecturer_id', $lecturerId)->pluck('id');

    $attendance = Trend::query(
        Attendance::query()
            ->whereIn('course_id', $lecturerCourseIds)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('COUNT(schedules_id) as aggregate')
            ->groupBy('month')
    )
    ->between(
        start: now()->startOfYear(),
        end: now()->endOfYear()
    )
    ->perMonth()
    ->count();

    return [
        'datasets' => [
            [
                'label' => 'Attendance',
                'data' => $attendance->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $attendance->map(fn (TrendValue $value) => $value->date),
    ];
}


    protected function getType(): string
    {
        return 'line';
    }
}
