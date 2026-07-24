<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Auth\Login as LoginPage;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(LoginPage::class)
            ->brandName('System Cek')
            ->defaultThemeMode(ThemeMode::Light)
            ->font('Inter')
            ->colors([
                'primary' => [
                    50 => '246, 250, 239',
                    100 => '230, 240, 216',
                    200 => '198, 220, 180',
                    300 => '151, 190, 132',
                    400 => '99, 150, 80',
                    500 => '63, 113, 51',
                    600 => '52, 96, 43',
                    700 => '41, 79, 36',
                    800 => '30, 58, 32',
                    900 => '24, 48, 26',
                    950 => '14, 30, 15',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->globalSearch(false)
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->renderHook(
                'panels::head.end',
                fn () => view('filament.custom-styles')
            )
            ->renderHook(
                'panels::simple-page.start',
                fn () => view('filament.auth.login-side-panel'),
                scopes: LoginPage::class,
            )
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
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
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->navigationGroup('Manajemen Pengguna')
                    ->navigationSort(2),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
