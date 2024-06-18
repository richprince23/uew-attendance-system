<?php

namespace App\Filament\Lecturer\Resources\StudentResource\Pages;

use App\Filament\Lecturer\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
