<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\StudentResource\Pages;
use App\Filament\Lecturer\Resources\StudentResource\RelationManagers;
use App\Filament\Lecturer\Widgets\StudentOverview;
use App\Models\Lecturer;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                TextColumn::make('name'),
                TextColumn::make('index_number'),
                TextColumn::make('level'),
                TextColumn::make('department.name')->label('Department'),
                // TextColumn::make('enrollments.course.course_name')->label('Course'), // works
            ])
            ->filters([
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            // 'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    // students only taking a lecturer's course
    public static function getEloquentQuery(): Builder
    {
        $lecturer = Lecturer::where('user_id', auth()->id())->first();

        return Student::query()
            ->whereHas('enrollments.course', function (Builder $query) use ($lecturer) {
                $query->where('lecturer_id', $lecturer->id);
            })
            ->distinct();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StudentOverview::class, // Register the widget here
            // Other widgets can be added here
        ];
    }
}
