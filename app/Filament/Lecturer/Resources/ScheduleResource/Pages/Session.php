<?php

namespace App\Filament\Lecturer\Resources\ScheduleResource\Pages;

use App\Filament\Lecturer\Resources\ScheduleResource;
use App\Models\Schedules;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Session extends Page implements HasForms
{
    protected static string $resource = ScheduleResource::class;

    protected static string $view = 'filament.lecturer.resources.schedule-resource.pages.session';

    protected static ?string $title = 'Start Attendance Session';
    public Schedules $record;

    public $schedules_id;
    public $duration;
    public $venue;

    public function mount(Schedules $record)
    {
        $this->record = $record;
    }


    public static function canAccess(array $parameters = []): bool
    {
        return Auth::user()->role == 'lecturer';
    }

}
