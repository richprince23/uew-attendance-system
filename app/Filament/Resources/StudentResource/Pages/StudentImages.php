<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Forms\Concerns\InteractsWithForms;

class StudentImages extends Page implements HasForms
{
    // use Forms\Concerns\InteractsWithForms; 
    protected static string $resource = StudentResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.student-images';

}
