<?php

namespace App\Filament\Lecturer\Resources\ScheduleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;



class AttendanceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('schedules_id')->numeric()->hidden(),
                TextInput::make('student_id')->required()->numeric(),
                TextInput::make('course_id')->required()->numeric(),
                DatePicker::make('date')->required(),
                TimePicker::make('time_in')->required(),
                Select::make('status')->options([
                    'present' => 'Present',
                    'absent' => 'Absent',
                    'permission' => 'On Permission',
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('schedules_id')

            ->columns([
                TextColumn::make('name') // Temporarily use 'student_id' to check if the query works
                    ->label('Student Name')
                    ->sortable(),
                TextColumn::make('attendance_count')
                    ->label('Attendance Count')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('attendance_count')
                ->form([
                    Forms\Components\TextInput::make('min')->numeric(),
                    Forms\Components\TextInput::make('max')->numeric(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['min'],
                            fn (Builder $query, $min): Builder => $query->having('attendance_count', '>=', $min),
                        )
                        ->when(
                            $data['max'],
                            fn (Builder $query, $max): Builder => $query->having('attendance_count', '<=', $max),
                        );
                })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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


    protected function getTableQuery(): Builder
    {
        return $this->getRelation()->getQuery()
            ->select('students.id', 'students.name')
            ->selectRaw('COUNT(DISTINCT attendances.id) as attendance_count')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->groupBy('students.id', 'students.name')
            ->orderBy('students.id');  // Changed from attendances.id to students.id
    }

//     protected function getTableQuery(): Builder
// {
//     $relation = $this->getRelation();

//     if (!$relation) {
//         throw new \Exception('Relation is null');
//     }

//     $query = $relation->getQuery();

//     if (!$query) {
//         throw new \Exception('Query is null');
//     }

//     return $query
//         ->select('attendances.*')
//         ->selectRaw('COUNT(DISTINCT attendances.student_id) as attendance_count')
//         ->join('students', 'attendances.student_id', '=', 'students.id')
//         ->groupBy('students.id', 'attendances.id');
// }

    protected function getRelation()
{
    return $this->ownerRecord->attendance();
}
}
