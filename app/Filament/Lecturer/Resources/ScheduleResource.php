<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\ScheduleResource\Pages;
use App\Filament\Lecturer\Resources\ScheduleResource\Pages\Session;
use App\Filament\Lecturer\Resources\ScheduleResource\RelationManagers;

use App\Filament\Lecturer\Resources\ScheduleResource\RelationManagers\AttendanceRelationManager;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedules;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
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

                Hidden::make('lecturer_id')->default($lecturer->id),
                TextInput::make('venue')->required(),
                TextInput::make('room'),
                Select::make('day')->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday'
                ]),
                TimePicker::make('start_time')->required(),
                TimePicker::make('end_time')->required(),

                // TextInput::make('lecturer_id')
                // ->default(function() {
                //     $lecturer = Lecturer::where('user_id', auth()->id())->first();
                //     return $lecturer ? $lecturer->id : null;
                // })
                // ->disabled()->hidden()
                // ->dehydrated(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        // ->query(function (Builder $query) {
        //     // Get the authenticated lecturer's ID
        //     $lecturer = Lecturer::where('user_id', auth()->id())->first();

        //     // Only show schedules for the logged-in lecturer
        //     if ($lecturer) {
        //         $query->where('lecturer_id', $lecturer->id);
        //     }
        // })
            ->columns([
                TextColumn::make('course.course_name')->searchable()->label('Course'),
                TextColumn::make('course.course_code')->searchable()->label('Course Code'),
                TextColumn::make('course.level')->sortable()->label('Level'),
                TextColumn::make('course.semester')->sortable()->label('Semester'),
                TextColumn::make('course.year')->sortable()->label('Year'),
                TextColumn::make('day')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('Start Session')
                ->url(fn (Schedules $record) => Session::getUrl(['record' => $record->id]))->color('success')->button()

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
            AttendanceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
            'new-session' => Pages\Session::route('/{record}/new-session')
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $lecturer= Lecturer::where('user_id', auth()->user()->id)->get()->first(); // get lecturer id from user
        // var_dump($lecturer->id);
        return parent::getEloquentQuery()
            ->where('lecturer_id', '=', $lecturer->id);
    }
}
