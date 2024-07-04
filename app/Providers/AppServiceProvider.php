<?php

namespace App\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('webcamjs', __DIR__ . '/../../resources/js/webcam.min.js')->loadedOnRequest(),
            Js::make('cam-controls', __DIR__ . '/../../resources/js/cam-controls.js')->loadedOnRequest(),
        ]);
    }
}
