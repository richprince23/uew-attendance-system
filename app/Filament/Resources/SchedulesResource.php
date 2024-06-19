<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchedulesResource\Pages;
use App\Filament\Resources\SchedulesResource\RelationManagers;
use App\Models\Schedules;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchedulesResource extends Resource
{
    protected static ?string $model = Schedules::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.course_code')->label('Course Code')->sortable()->searchable(),
                TextColumn::make('lecturer.name')->label('Lecturer')->sortable()->searchable(),
                TextColumn::make('venue')->label('Venue')->sortable()->searchable(),
                TextColumn::make('room')->label('Room')->sortable()->searchable(),
                TextColumn::make('day')->label('Day')->sortable()->searchable(),
                TextColumn::make('start_time')->label('Start')->sortable()->searchable()->time('H:i'),
                TextColumn::make('end_time')->label('End')->sortable()->searchable()->time('H:i'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedules::route('/create'),
            'edit' => Pages\EditSchedules::route('/{record}/edit'),
        ];
    }
}
