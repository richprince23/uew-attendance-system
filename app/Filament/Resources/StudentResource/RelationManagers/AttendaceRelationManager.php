<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Actions\Action;
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

class AttendaceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';
    protected static ?string $title = 'Attendance Records';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('student_id')->required()->numeric(),
                // TextInput::make('attendance.course.course_code')->required()->numeric(),
                // TextInput::make('attendance.course.year')->required()->numeric(),
                // TextInput::make('attendance.course.semester')->required(),
                // TextInput::make('attendance.course.lecturer.name')->required()->maxLength(255),
                // TextInput::make('date'),
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
                ExportAction::make()
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
