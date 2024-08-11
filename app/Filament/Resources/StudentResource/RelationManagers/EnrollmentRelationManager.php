<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollment';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Select::make('course_id')->relationship('course', 'course_name'),
    //             TextInput::make('student_id')->visible(false)->default('student_id')
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_id')
            ->columns([
                Tables\Columns\TextColumn::make('course.course_name'),
                Tables\Columns\TextColumn::make('course.course_code'),
                Tables\Columns\TextColumn::make('course.year')->label('Year'),
                Tables\Columns\TextColumn::make('course.semester')->label('Semester'),
                Tables\Columns\TextColumn::make('course.lecturer.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
