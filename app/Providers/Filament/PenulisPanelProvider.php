<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class PenulisPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('penulis')
            ->path('penulis')
            ->login()
            ->homeUrl('/redirect-panel')
            ->brandName('Honai Jurnalis — Penulis')
            ->brandLogo(function () {
                $logoSetting = \App\Models\Setting::where('key', 'site_logo')->value('value');
                $name = \App\Models\Setting::where('key', 'site_name')->value('value')
                    ?? 'Honai Jurnalis Kampung';

                $logoSrc = $logoSetting
                    ? asset('storage/' . $logoSetting)
                    : asset('images/logo-hjk.png');

                return new \Illuminate\Support\HtmlString(
                    '<div style="display:flex;align-items:center;gap:10px;">'
                    . '<img src="' . $logoSrc . '" style="height:42px;width:42px;object-fit:contain;" alt="Logo">'
                    . '<span style="font-family:Georgia,serif;font-weight:700;font-size:15px;color:#1a1a1a;">'
                    . e($name)
                    . '</span>'
                    . '</div>'
                );
            })
            ->brandLogoHeight('46px')
            ->favicon(asset('images/logo-hjk.png'))
            ->colors(['primary' => Color::Green])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->discoverResources(in: app_path('Filament/Penulis/Resources'), for: 'App\\Filament\\Penulis\\Resources')
            ->discoverPages(in: app_path('Filament/Penulis/Pages'), for: 'App\\Filament\\Penulis\\Pages')
            ->pages([Pages\Dashboard::class])
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,  // ← tambahkan ini
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
            ->authMiddleware([Authenticate::class]);
    }
}
