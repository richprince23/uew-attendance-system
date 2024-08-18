<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchedulesResource\Pages;
use App\Filament\Resources\SchedulesResource\RelationManagers;
use App\Filament\Resources\SchedulesResource\RelationManagers\AttendanceRelationManager;
use App\Filament\Resources\SchedulesResource\RelationManagers\StudentRelationManager;
use App\Models\Department;
use App\Models\Schedules;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
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

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select::make('course.course_code')->relationship('course', 'course_name')->searchable()->disabledOn('edit'),
                // Select::make('lecturer.name')->relationship('lecturer', 'name')->searchable()->disabledOn('edit'),
                //  Forms\Components\Select::make('department_id')
                //     ->label('Department')
                //     ->options(Department::pluck('name', 'id'))->searchable()->disabledOn('edit'),
                // TimePicker::make('start_time')->required()->disabledOn('edit'),
                // TimePicker::make('end_time')->required()->disabledOn('edit'),
                // TextInput::make('venue')->required()->disabledOn('edit'),
                // TextInput::make('room')->disabledOn('edit'),
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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // StudentRelationManager::class,
            AttendanceRelationManager::class,
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
