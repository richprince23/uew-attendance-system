<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\DeleteAction;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')->label('Name'),
                TextEntry::make('index_number')->label('Index Number'),
                TextEntry::make('department.name')->label('Department'),
                TextEntry::make('phone')->label('Contact'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('level')->label('level'),
                TextEntry::make('group')->label('group'),
                TextEntry::make('gender')->label('Gender'),
            ]);
    }

    public function actions(\Filament\Infolists\Components\Actions $actions)
    {
        return [

            Action::make('save')
                ->icon('heroicon-m-x-mark')
                ->color('danger')
                ->requiresConfirmation()

        ];
    }
}
