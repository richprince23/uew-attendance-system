<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\ScheduleResource\Pages;
use App\Filament\Lecturer\Resources\ScheduleResource\RelationManagers;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedules;
use Filament\Forms;
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

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedules::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
         $lecturer = Lecturer::where('user_id', auth()->user()->id)->get()->first();
        return $form
            ->schema([
                Select::make('course_id')->placeholder('Select a course')
                ->label('Course')
                ->options(function () {
                    $lecturer = Lecturer::where('user_id', auth()->id())->first();

                    if (!$lecturer) {
                        return [];
                    }

                    return Course::where('lecturer_id', $lecturer->id)
                        ->pluck('course_name', 'id')
                        ->toArray();
                })
                ->searchable()
                ->required(),

                TextInput::make('lecturer_id')->default($lecturer->id)->disabled()->dehydrated(),
                TextInput::make('venue')->required(),
                TextInput::make('room'),
                Select::make('day')->options([
                    'Monday' =>'Monday',
                    'Tuesday'=>'Tuesday',
                    'Wednesday'=>'Wednesday',
                    'Thursday'=>'Thursday',
                    'Friday'=>'Friday',
                    'Saturday'=>'Saturday',
                    'Sunday'=>'Sunday'
                ]),
                TimePicker::make('start_time')->required(),
                TimePicker::make('end_time')->required(),

                // TextInput::make('lecturer_id')
                // ->default(function() {
                //     $lecturer = Lecturer::where('user_id', auth()->id())->first();
                //     return $lecturer ? $lecturer->id : null;
                // })
                // ->disabled()
                // ->dehydrated(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.course_name'),
                TextColumn::make('course.course_code'),
                TextColumn::make('course.level'),
                TextColumn::make('course.semester'),
                TextColumn::make('day'),
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
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
