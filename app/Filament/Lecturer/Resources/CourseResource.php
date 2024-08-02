<?php

namespace App\Filament\Lecturer\Resources;

use App\Filament\Lecturer\Resources\CourseResource\Pages;
use App\Filament\Lecturer\Resources\CourseResource\RelationManagers;
use App\Filament\Lecturer\Resources\CourseResource\RelationManagers\EnrollmentRelationManager;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\User;
use Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course_code')->label('Course Code')->searchable()->sortable(),
                TextColumn::make('course_name')->label('Course Name')->searchable()->sortable(),
                TextColumn::make('semester')->label('Semester')->searchable()->sortable(),
                TextColumn::make('level')->label('Level')->searchable()->sortable(),
                TextColumn::make('year')->label('Year')->searchable()->sortable(),
                TextColumn::make('lecturer.name')->label('Year')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            // ->query( fn ($query) => $query->byLecturer(Auth::user()->id))
            ->actions([
                Tables\Actions\ViewAction::make(),
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

    public static function getRelations(): array
    {
        return [
            EnrollmentRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            // 'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
