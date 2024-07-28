<?php

namespace App\Filament\Lecturer\Pages;

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
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Lecturer/Resources'), for: 'App\\Filament\\Lecturer\\Resources')
            ->discoverPages(in: app_path('Filament/Lecturer/Pages'), for: 'App\\Filament\\Lecturer\\Pages')
            ->pages([
                Dashboard::class,
            ]);

    }
}