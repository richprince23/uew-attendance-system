<?php

namespace App\Filament\Lecturer\Resources\ScheduleResource\Pages;

use App\Filament\Lecturer\Resources\ScheduleResource;
use Filament\Resources\Pages\Page;

class Session extends Page
{
    protected static string $resource = ScheduleResource::class;

    protected static string $view = 'filament.lecturer.resources.schedule-resource.pages.session';
}
