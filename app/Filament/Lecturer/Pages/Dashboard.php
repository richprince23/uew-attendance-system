<?php

namespace App\Filament\Lecturer\Pages;

use App\Filament\Lecturer\Widgets\AttendanceTrend;
use App\Filament\Lecturer\Widgets\EnrollmentOverview;
use Filament\Panel;
use Filament\Support\Colors\Color;

class Dashboard extends \Filament\Pages\Dashboard
{


    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('lecturer')
            ->path('lecturer')
            ->login()
            // ->passwordReset()
            // ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Lecturer/Resources'), for: 'App\\Filament\\Lecturer\\Resources')
            ->discoverPages(in: app_path('Filament/Lecturer/Pages'), for: 'App\\Filament\\Lecturer\\Pages')
            // ->discoverWidgets()
            ->widgets([
                // EnrollmentOverview::class,
                // AttendanceTrend::class,
            ])
            ->pages([
                Dashboard::class,
            ]);

    }
}
