<?php

namespace App\Filament\Lecturer\Resources\CourseResource\Pages;

use App\Filament\Lecturer\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}
