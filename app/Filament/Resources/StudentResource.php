<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Filament\Resources\StudentResource\RelationManagers\AttendaceRelationManager;
use App\Filament\Resources\StudentResource\RelationManagers\DepartmentRelationManager;
use App\Filament\Resources\StudentResource\RelationManagers\EnrollmentRelationManager;
use App\Models\Department;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Components\Tab;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



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
                // TextColumn::make('other_names')
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('surname')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('index_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('group')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('is_featured')
                ->query(fn (Builder $query): Builder => $query->where('department', '>', 400)),
                // SelectFilter::make('department')
                // ->multiple()
                // ->options(Department::class)
                SelectFilter::make('department')->relationship('department', 'name')

            #
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Export')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->openUrlInNewTab()
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records) {
                        return response()->streamDownload(function () use ($records) {
                            echo Pdf::loadHTML(
                                Blade::render('StudentPDF', ['records' => $records])
                            )->stream();
                        }, 'student-list.pdf');
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // DepartmentRelationManager::class,
            EnrollmentRelationManager::class,
            AttendaceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
