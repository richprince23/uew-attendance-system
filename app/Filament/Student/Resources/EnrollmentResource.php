<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\EnrollmentResource\Pages;
use App\Filament\Student\Resources\EnrollmentResource\RelationManagers;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Form $form): Form
    {
        $student = Student::where('user_id', auth()->id())->get()->first();
        $studentId = $student->id;
        return $form
            ->schema([
                TextInput::make('student_id')->required()->default($studentId),
                // Department Selection
                Select::make('department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    // ->required()
                    ->reactive() // Makes the select component reactive
                    ->afterStateUpdated(fn(callable $set) => $set('course_id', null)), // Clear course_id when department changes

                // Course Selection populated based on department
                Select::make('course_id')
                    ->label('Course')
                    ->options(function ($get) {
                        $departmentId = $get('department_id');
                        if ($departmentId) {
                            return Course::where('department_id', $departmentId)->pluck('course_name', 'id');
                        }
                        return [];
                    })
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Fetch the course and set the year
                        $course = Course::find($state);
                        if ($course) {
                            $set('year', $course->year); // Assuming 'year' is a property of the Course model
                        }
                    }),

                // Readonly Year TextInput populated based on selected course
                TextInput::make('year')
                    ->label('Year')
                    ->required()
                    ->reactive()
                    ->readOnly(),


                Select::make('semester')
                    ->options([
                        'first' => 'First Semester',
                        'second' => 'Second Semester',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make()
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
