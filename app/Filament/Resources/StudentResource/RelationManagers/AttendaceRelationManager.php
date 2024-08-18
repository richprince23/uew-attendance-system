<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Exports\StudentAttendanceExporter;
use Filament\Actions\Action;
use Filament\Actions\Exports\Models\Export;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class AttendaceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';
    protected static ?string $title = 'Attendance Records';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_id')
            ->columns([
                // TextColumn::make('student_id'),
                TextColumn::make('student.index_number')->label("Index Number")->searchable()->sortable(),
                TextColumn::make('course.course_code')->label("Course Code")->searchable()->sortable(),
                TextColumn::make('course.year')->label("Course Year")->searchable()->sortable(),
                TextColumn::make('course.semester')->label("Semester")->searchable()->sortable(),
                TextColumn::make('course.lecturer.name')->label("Lecturer")->searchable()->sortable(),
                TextColumn::make('date')->label("Date")->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->groups([
                Group::make('course.course_name')->label('Course'),
                Group::make('course.lecturer.name')->label('Lecturer'),
                Group::make('course.semester')->label('Semester'),
                Group::make('course.year')->label('Year'),
                Group::make('date')->label('Date'),

            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                ExportAction::make()->exporter(StudentAttendanceExporter::class)->after(function (Export $export) {
                    // Generate the download URL
                    return Storage::disk('public')->url($export->getFileDirectory() . $export->file_name);

                    // Redirect to the download URL
                    // return redirect()->to($url);
                })->label('Export')
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\ExportBulkAction::make(StudentAttendanceExporter::class)->after(
                        function (Export $export) {
                            // Generate the download URL
                            return Storage::disk('public')->url($export->getFileDirectory() . $export->file_name);
                        }
                    ),
                ]),
            ]);
    }
}
