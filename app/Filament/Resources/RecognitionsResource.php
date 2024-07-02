<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecognitionsResource\Pages;
use App\Filament\Resources\RecognitionsResource\RelationManagers;
use App\Filament\Resources\RecognitionsResource\RelationManagers\StudentRelationManager;
use App\Models\Recognitions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecognitionsResource extends Resource
{
    protected static ?string $model = Recognitions::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

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
                //
            ])
            ->filters([
                //
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
            StudentRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecognitions::route('/'),
            'create' => Pages\CreateRecognitions::route('/create'),
            'edit' => Pages\EditRecognitions::route('/{record}/edit'),
        ];
    }
}
