<?php

namespace App\Filament\Lecturer\Resources\CourseResource\RelationManagers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('course_id')->required()->maxLength(12),
               TextInput::make('student_id')->required()->maxLength(12),
               TextInput::make('year')->required(),
               TextInput::make('semester')->required()->maxLength(12),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('course_id')
            ->columns([
                Tables\Columns\TextColumn::make('course.course_name'),
                Tables\Columns\TextColumn::make('student.name'),
                Tables\Columns\TextColumn::make('student.index_number')->label('Index Number'),
                Tables\Columns\TextColumn::make('course.semester'),
                Tables\Columns\TextColumn::make('year'),
            ])
            ->filters([
                SelectFilter::make('course_level')
                ->label('Course Level')
                ->options([
                    100 => 'Level 100',
                    200 => 'Level 200',
                    300 => 'Level 300',
                    400 => 'Level 400',
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['value'],
                        fn (Builder $query, $level): Builder => $query->whereHas('course', function ($q) use ($level) {
                            $q->where('level', $level);
                        })
                    );
                }),

            SelectFilter::make('course_semester')
                ->label('Semester')
                ->options(function () {
                    return Course::distinct()->pluck('semester', 'semester')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['value'],
                        fn (Builder $query, $semester): Builder => $query->whereHas('course', function ($q) use ($semester) {
                            $q->where('semester', $semester);
                        })
                    );
                }),

            SelectFilter::make('student_department')
                ->label('Student Department')
                ->options(function () {
                    return Department::pluck('name', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['value'],
                        fn (Builder $query, $departmentId): Builder => $query->whereHas('student', function ($q) use ($departmentId) {
                            $q->where('department_id', $departmentId);
                        })
                    );
                }),

            SelectFilter::make('student_level')
                ->label('Student Level')
                ->options([
                    100 => 'Level 100',
                    200 => 'Level 200',
                    300 => 'Level 300',
                    400 => 'Level 400',
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['value'],
                        fn (Builder $query, $level): Builder => $query->whereHas('student', function ($q) use ($level) {
                            $q->where('level', $level);
                        })
                    );
                }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $lecturer= Lecturer::where('user_id', auth()->user()->id)->get()->first(); // get lecturer id from user
        // var_dump($lecturer->id);

        return parent::getEloquentQuery()
            ->where('lecturer_id', '=', $lecturer->id);
    }

    // public function getTabs(): array
    // {
    //     return [
    //         'all' => Tab::make(),
    //         'Level 100' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('courses.level', 100)),
    //         'Level 200' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 200)),
    //         'Level 300' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 300)),
    //         'Level 400' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 400)),
    //         'Males' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'male')),
    //         'Females' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'female')),
    //     ];
    // }
}
