<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('department_id')->hidden(),
                TextInput::make('course_name')->required()->maxLength(255)->required(),
                TextInput::make('course_code')->required()->maxLength(7)->rules('uppercase')->required(),
                Select::make('semester')->required()->options([
                    'First' =>'First',
                    'Second'=> 'Second'
                ])->required(),
                Select::make('level')->required()->options([
                    '100' =>'100',
                    '200' =>'200',
                    '300' =>'300',
                    '400' =>'400',
                ])->required(),
                TextInput::make('year')->required()->numeric()->maxLength(4)->required(),
                Select::make('lecturer_id')->relationship('lecturer', 'name')->searchable()->reactive()->required()

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('department_id')
            ->columns([
                Tables\Columns\TextColumn::make('department_id'),
                Tables\Columns\TextColumn::make('course_name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('course_code')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('lecturer.name'),
            Tables\Columns\TextColumn::make('year')->sortable(),
            Tables\Columns\TextColumn::make('semester')->sortable(),
            Tables\Columns\TextColumn::make('department.name')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->modal(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
