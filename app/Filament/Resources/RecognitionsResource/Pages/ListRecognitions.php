<?php

namespace App\Filament\Resources\RecognitionsResource\Pages;

use App\Filament\Resources\RecognitionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecognitions extends ListRecords
{
    protected static string $resource = RecognitionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
