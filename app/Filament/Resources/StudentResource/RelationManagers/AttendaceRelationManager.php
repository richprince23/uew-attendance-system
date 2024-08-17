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
                TextColumn::make('student.index_number')->label("Index Number"),
                TextColumn::make('course.course_code')->label("Course Code"),
                TextColumn::make('course.year')->label("Course Year"),
                TextColumn::make('course.semester')->label("Semester"),
                TextColumn::make('course.lecturer.name')->label("Lecturer"),
                TextColumn::make('date')->label("Date"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                ExportAction::make()->exporter(StudentAttendanceExporter::class)->after(function (Export $export) {
                    // Generate the download URL
                    $url = Storage::disk('public')->url($export->getFileDirectory() .$export->file_name);

                    // Redirect to the download URL
                    return redirect()->to($url);
                })
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
