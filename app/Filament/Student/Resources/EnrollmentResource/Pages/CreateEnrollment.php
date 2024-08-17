<?php

namespace App\Filament\Student\Resources\EnrollmentResource\Pages;

use App\Filament\Student\Resources\EnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;
}
