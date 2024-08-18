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

    protected function getLecturerId(): int
    {
        $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();
        return $lecturer->id ?? 0;
    }

    protected function getLecturerCourseIds(): array
    {
        $lecturerId = $this->getLecturerId();
        return Course::where('lecturer_id', $lecturerId)->pluck('id')->toArray();
    }

    protected function getAttendanceData(): array
    {
        $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();

        $lecturerId = $lecturer->id ?? 0;

        $lecturerCourseIds = Course::where('lecturer_id', $lecturerId)->pluck('id');

        $semester = Course::whereIn('id', $lecturerCourseIds)->first()->semester;

        $start = $semester === 'first' ? now()->startOfYear() : now()->startOfYear()->addMonths(5);
        $end = $semester === 'first' ? now()->startOfYear()->addMonths(5) : now()->endOfYear();

        $attendance = Trend::query(
            Attendance::query()
                ->whereIn('course_id', $lecturerCourseIds)
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
                ->selectRaw('COUNT(schedules_id) as aggregate')
                ->groupBy('month')
        )
        ->between(
            start: $start,
            end: $end
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

    protected function getData(): array
    {
        try {
            return $this->getAttendanceData();
        } catch (\Exception $e) {
            // Handle error
            return [];
        }
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
