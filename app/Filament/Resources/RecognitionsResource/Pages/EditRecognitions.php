<?php

namespace App\Filament\Resources\RecognitionsResource\Pages;

use App\Filament\Resources\RecognitionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecognitions extends EditRecord
{
    protected static string $resource = RecognitionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
