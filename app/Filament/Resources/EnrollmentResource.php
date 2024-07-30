<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Filament\Resources\EnrollmentResource\RelationManagers\CourseRelationManager;
use App\Filament\Resources\EnrollmentResource\RelationManagers\CoursesRelationManager;
use App\Filament\Resources\EnrollmentResource\RelationManagers\StudentRelationManager;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function getStateUsing(Model $record): array
    {
        return [
            'student_name' =>  $record->name,
        ];
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('course.course_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('year')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('semester')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('semester')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('course.level')
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
            CourseRelationManager::class,
            StudentRelationManager::class,
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
