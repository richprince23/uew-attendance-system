<?php

namespace App\Providers\Filament;

use App\Filament\Auth\LecturerLogin;
use App\Filament\Lecturer\Pages\App\Profile;
use App\Filament\Lecturer\Widgets\AttendanceTrend;
use App\Filament\Lecturer\Widgets\EnrollmentOverview;
use App\Filament\Widgets\CourseAttendanceChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class LecturerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('lecturer')
            ->path('lecturer')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->login(LecturerLogin::class)
            ->passwordReset()
            ->databaseNotifications()
            ->profile(isSimple: false)
            ->discoverResources(in: app_path('Filament/Lecturer/Resources'), for: 'App\\Filament\\Lecturer\\Resources')
            ->discoverPages(in: app_path('Filament/Lecturer/Pages'), for: 'App\\Filament\\Lecturer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Lecturer/Widgets'), for: 'App\\Filament\\Lecturer\\Widgets')
            ->widgets([
                // AttendanceTrend::class,
                CourseAttendanceChart::class,
                EnrollmentOverview::class,
            ])
            // ->authGuard('lecturer')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                // IsLecturer::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Profile')
                    ->icon('heroicon-o-user-circle')
                    ->url(static fn(): string => route(Profile::getRouteName(panel: 'lecturer'))),
            ]);
    }
}
