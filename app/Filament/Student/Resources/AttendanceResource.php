<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\AttendanceResource\Pages;
use App\Filament\Student\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('student.name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('student.index_number')
                    ->label('Student Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('attendance_count')
                    ->label('Attendance Count')
                    ->sortable(),
            ])
            ->filters([
                // You can add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) =>
            $query->selectRaw('students.name as student_name, students.index_number, courses.course_name, COUNT(attendances.id) as attendance_count')
                  ->join('students', 'attendances.student_id', '=', 'students.id')
                  ->join('courses', 'attendances.course_id', '=', 'courses.id')
                  ->groupBy('students.name', 'students.index_number', 'courses.course_name')
        );
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
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    // protected function getTableQuery(): Builder
    // {
    //     return $this->getRelation()->getQuery()
    //         ->select('students.id', 'students.name', 'students.index_number', )
    //         ->selectRaw('COUNT(DISTINCT attendances.id) as attendance_count')
    //         ->join('students', 'attendances.student_id', '=', 'students.id')
    //         ->groupBy('students.id', 'students.name')
    //         ->orderBy('students.id');  // Changed from attendances.id to students.id
    // }

    // protected function getRelation()
    // {
    //     return $this->ownerRecord->attendance();
    // }
}
