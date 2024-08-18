<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lecturer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class CourseAttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Course Attendance Summary';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $lecturer = Lecturer::where('user_id', Auth::id())->first();

        if (!$lecturer) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $lecturerCourses = Course::where('lecturer_id', $lecturer->id)->pluck('id');

        $attendances = Attendance::whereIn('course_id', $lecturerCourses)
            ->selectRaw('course_id, COUNT(*) as attendance_count')
            ->groupBy('course_id')
            ->get();

        $labels = [];
        $data = [];

        foreach ($attendances as $attendance) {
            $course = Course::find($attendance->course_id);
            if ($course) {
                $labels[] = $course->course_name;
                $data[] = $attendance->attendance_count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Attendance Stats',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
