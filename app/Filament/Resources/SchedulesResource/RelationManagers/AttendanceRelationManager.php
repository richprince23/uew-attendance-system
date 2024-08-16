<?php

namespace App\Filament\Resources\SchedulesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('date'),
                Forms\Components\TextInput::make('time_in'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('schedules_id')
            ->columns([
            //     Tables\Columns\TextColumn::make('schedules_id')->hidden(),
            //     Tables\Columns\TextColumn::make('student.name')->searchable()->sortable(),
            //     Tables\Columns\TextColumn::make('student.index_number')->sortable()->searchable()->label('Index Number'),
            //     Tables\Columns\TextColumn::make('student_id')->summarize(Count::make())->sortable()->searchable(),
            //     Tables\Columns\TextColumn::make('date')->sortable()->searchable(),
            //     Tables\Columns\TextColumn::make('time_in')->sortable()->searchable(),

            TextColumn::make('name') // Temporarily use 'student_id' to check if the query works
                ->label('Student Name')
                ->sortable()->searchable(),
            TextColumn::make('index_number') // Temporarily use 'student_id' to check if the query works
                ->label('Student Number')
                ->sortable()->searchable(),
            TextColumn::make('attendance_count')
                ->label('Attendance Count')
                ->sortable(),
                ])
            ->filters([
                SelectFilter::make('course')->relationship('course', 'course_name'),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return $this->getRelation()->getQuery()
            ->select('students.id', 'students.name', 'students.index_number', )
            ->selectRaw('COUNT(DISTINCT attendances.id) as attendance_count')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->groupBy('students.id', 'students.name')
            ->orderBy('students.id');  // Changed from attendances.id to students.id
    }

    protected function getRelation()
    {
        return $this->ownerRecord->attendance();
    }
}
