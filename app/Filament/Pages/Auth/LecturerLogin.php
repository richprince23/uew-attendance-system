<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login;
use Illuminate\Contracts\Support\Htmlable;

class LecturerLogin extends Login
{
    public function getHeading(): string|Htmlable
    {
        return __('Lecturer Login');
    }
}
