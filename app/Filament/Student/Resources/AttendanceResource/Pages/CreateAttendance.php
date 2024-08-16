<?php

namespace App\Filament\Student\Resources\AttendanceResource\Pages;

use App\Filament\Student\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
