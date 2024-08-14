<?php

namespace App\Filament\Lecturer\Resources\ScheduleResource\Pages;

use App\Filament\Lecturer\Resources\ScheduleResource;
use App\Models\Schedules;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Session extends Page implements HasForms
{
    protected static string $resource = ScheduleResource::class;

    protected static string $view = 'filament.lecturer.resources.schedule-resource.pages.session';

    protected static ?string $title = 'Attendance Session';
    public Schedules $record;

    public function mount(Schedules $record)
    {
        $this->record = $record;
    }


    public static function canAccess(array $parameters = []): bool
    {
        return Auth::user()->role == 'lecturer';
    }
}
