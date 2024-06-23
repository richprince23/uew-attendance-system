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
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                TextInput::make('other_names')->required()->rules('string')->maxLength(50),
                TextInput::make('surname')->required()->rules('string')->maxLength(50),
                TextInput::make('email')->required()->rules('email')->maxLength(50),
                TextInput::make('phone')->required()->rules('numeric|min_digits:10|max_digits:10'),
                TextInput::make('index_number')->required()->rules('numeric|min_digits:9|max_digits:12'),
                Select::make('gender')->required()->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                ]),
                Select::make('level')->required()->options([
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                ]),
                Select::make('group')->required()->options([
                    'Group 1' => 'Group 1',
                    'Group 2' => 'Group 2',
                    'Group 3' => 'Group 3',
                    'Group 4' => 'Group 4',
                    'Group 5' => 'Group 5',
                    'Group 6' => 'Group 6',
                    'Group 7' => 'Group 7',
                    'Group 8' => 'Group 8',
                    'Group 9' => 'Group 9',
                    'Group 10' => 'Group 10',


                ]),
                Select::make('department_id')->label('Select Department')->relationship('department', 'name')->searchable()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('other_names')->hidden()->searchable()->sortable(),
                TextColumn::make('surname')->hidden()->searchable()->sortable(),
                TextColumn::make('name'),
                TextColumn::make('index_number')->searchable()->sortable(),
                TextColumn::make('level')->searchable()->sortable(),
                // TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('group')->searchable()->sortable(),
                TextColumn::make('department.name')->searchable()->sortable(),
                // TextColumn::make('phone')->searchable()->sortable(),
            ])
            ->filters([
                Filter::make('graduated')
                    ->query(fn(Builder $query): Builder => $query->where('level', '>', 400)),
                // SelectFilter::make('department')
                // ->multiple()
                // ->options(Department::class)
                SelectFilter::make('department')->relationship('department', 'name')->searchable()

                #
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('image')->url(fn ($record) => StudentResource::getUrl('image', ['record' => $record]))
                ->label('Images')
                ->icon('heroicon-o-face-smile'),
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
            'image' => Pages\StudentImages::route('/{record}/images'),
        ];
    }
}
