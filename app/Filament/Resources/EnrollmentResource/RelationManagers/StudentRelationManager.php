<?php

namespace App\Filament\Resources\EnrollmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentRelationManager extends RelationManager
{
    protected static string $relationship = 'student';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('index_number')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('surname')
            ->columns([
                Tables\Columns\TextColumn::make('index_number'),
                Tables\Columns\TextColumn::make('other_names'),
                Tables\Columns\TextColumn::make('surname'),
                Tables\Columns\TextColumn::make('level'),
                Tables\Columns\TextColumn::make('group'),
                Tables\Columns\TextColumn::make('department.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
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
