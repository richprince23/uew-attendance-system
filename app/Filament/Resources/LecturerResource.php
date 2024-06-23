<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LecturerResource\Pages;
use App\Filament\Resources\LecturerResource\RelationManagers;
use App\Filament\Resources\LecturerResource\RelationManagers\DepartmentRelationManager;
use App\Models\Department;
use App\Models\Lecturer;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\AssociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Livewire;

class LecturerResource extends Resource
{
    protected static ?string $model = Lecturer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->string(),
                TextInput::make('phone')->required()->numeric()->maxLength(10),
                TextInput::make('email')->required()->rules('email'),
                // Forms\Components\Select::make('department_id')
                //     ->label('Department')
                //     // ->dehydrated(false)
                //     ->options(Department::pluck('name', 'id'))
                //     // ->afterStateUpdated(function (Livewire $livewire) {
                //     //     $livewire->reset('data.department.id');
                //     // }),

                Select::make('department_id')->label('Select Department')->relationship('department', 'name')->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->label('Lecturer Name'),
                TextColumn::make('department.name')->searchable()->sortable()->label('Department'),
                TextColumn::make('phone')->searchable()->sortable()->label('Contact'),
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
            // DepartmentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLecturers::route('/'),
            'create' => Pages\CreateLecturer::route('/create'),
            'edit' => Pages\EditLecturer::route('/{record}/edit'),
        ];
    }
}
