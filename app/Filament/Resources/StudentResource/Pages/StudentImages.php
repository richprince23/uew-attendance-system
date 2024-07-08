<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Forms\Concerns\InteractsWithForms;

class StudentImages extends Page implements HasForms
{
    // use Forms\Concerns\InteractsWithForms;
    protected static string $resource = StudentResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.student-images';

    public Student $record;

    public function mount($record)
    {
        $studentId = $record;
        // Do something with the student ID
        return view("filament.resources.student-resource.pages.student-images")->with(['studentId' => $studentId]);

    }

}
