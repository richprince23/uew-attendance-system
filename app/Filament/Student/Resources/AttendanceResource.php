<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\AttendanceResource\Pages;
use App\Filament\Student\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

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
                TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('time_in')
                    ->time()
                    ->sortable(),
                TextColumn::make('course.year')
                    ->sortable(),
                TextColumn::make('course.semester')
                    ->sortable(),
                TextColumn::make('status')
                    ->sortable(),
                TextColumn::make('attendance_count')
                    ->label('Attendance Count')
                    ->sortable(),
                TextColumn::make('status')
                    ->numeric()
                    ->summarize([
                        Count::make()->label('Total'),
                    ])
            ])
            ->filters([
                SelectFilter::make('course_id')
                ->label('Course')
                ->options(function () {
                    $student = Student::where('user_id', auth()->user()->id)->firstOrFail();
                    return Attendance::where('student_id', $student->id)
                        ->join('courses', 'attendances.course_id', '=', 'courses.id')
                        ->distinct('courses.id')
                        ->pluck('courses.course_name', 'courses.id')
                        ->toArray();
                })
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            // 'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    // protected function getTableQuery(): Builder
    // {
    //     $student = Student::where('user_id', auth()->id())->get()->first();
    //     $studentId = $student->id;

    //     return Attendance::query()
    //     ->select('attendances.id', 'attendances.date', 'attendances.time_in', 'attendances.status')
    //     ->selectRaw('courses.course_name')
    //     ->join('courses', 'attendances.course_id', '=', 'courses.id')
    //     ->where('attendances.student_id', $studentId)
    //     ->orderBy('attendances.date', 'desc');
    // }

    public static function getEloquentQuery(): Builder
    {
        $student = Student::where('user_id', auth()->user()->id)->get()->first(); // get lecturer id from user

        return parent::getEloquentQuery()
            // ->where('student_id', $student->id)
            // ->with('course') // Eager load the course relationship
            // ->orderBy('date', 'desc');
            ->where('student_id', $student->id)
            ->with('course')
            ->select('attendances.*')
            ->join('courses', 'attendances.course_id', '=', 'courses.id')
            ->distinct('courses.id')
            ->orderBy('date', 'desc');
    }
}
