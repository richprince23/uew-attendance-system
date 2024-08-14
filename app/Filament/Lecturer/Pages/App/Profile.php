<?php

namespace App\Filament\Lecturer\Pages\App;


use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.lecturer.pages.app.profile';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Update Profile';

    protected function getViewData(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }
}
