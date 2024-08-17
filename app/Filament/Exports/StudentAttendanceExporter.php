<?php

namespace App\Filament\Exports;

use App\Models\StudentAttendance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\Storage;

class StudentAttendanceExporter extends Exporter
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('student.index_number')->label('Index Number'),
            ExportColumn::make('course.course_code')->label('Course Code'),
            ExportColumn::make('course.year')->label('Course Year'),
            ExportColumn::make('course.semester')->label('Semester'),
            ExportColumn::make('course.lecturer.name')->label('Lecturer'),
            ExportColumn::make('date')->label('Date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student attendance export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public  function getFileDisk(): string
    {
        return 'public';
    }

    public static function getFileUrl(Export $export): string
    {
        return Storage::disk('public')->url($export->file_name);
    }
}
