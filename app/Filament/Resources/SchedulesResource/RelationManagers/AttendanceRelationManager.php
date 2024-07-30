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
                Tables\Columns\TextColumn::make('schedules_id')->hidden(),
                Tables\Columns\TextColumn::make('student.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('student.index_number')->sortable()->searchable()->label('Index Number'),
                Tables\Columns\TextColumn::make('student_id')->summarize(Count::make())->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('time_in')->sortable()->searchable(),

            ])->groups([
                    'student.index_number',
                    'course.course_name',
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
}
