<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                // TextInput::make('email')->required()->maxLength(255)->email(),
                Select::make('role')->options([
                    'lecturer' => 'Lecturer',
                    'admin' => 'Admin',
                ])->label('User Type')->hiddenOn('edit'),
                TextInput::make('password')->required()->minLength(8)->password()->revealable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->label('Name'),
                TextColumn::make('email')->searchable()->sortable()->label('Email'),
                TextColumn::make('role')->searchable()->sortable()->label('User Type'),

            ])
            ->filters([
                Filter::make('isNotAdmin')->default()
                    ->query(fn(Builder $query): Builder => $query->where('role', '!=', 'admin'))->label('Users'),
            ])
            ->groups([
                Group::make('role')
                ->getTitleFromRecordUsing(fn (User $record): string => ucfirst($record->role)),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
