<?php

namespace App\Providers\Filament;

use AchyutN\FilamentLogViewer\FilamentLogViewer;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use WallaceMartinss\FilamentEvolution\FilamentEvolutionPlugin;

class SuperPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('super')
            ->path('super')
            ->login()
           // ->authGuard('super')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(fn () => Vite::asset(config('teamkit.favicon.logo')))
            ->brandLogoHeight(fn () => request()->is('super/login', 'super/password-reset/*') ? '60px' : '50px')
            ->viteTheme('resources/css/filament/super/theme.css')
            ->defaultThemeMode(config('teamkit.theme_mode', ThemeMode::Dark))
            ->discoverClusters(in: app_path('Filament/Super/Clusters'), for: 'App\\Filament\\Super\\Clusters')
            ->discoverPages(in: app_path('Filament/Super/Pages'), for: 'App\\Filament\\Super\\Pages')
            ->discoverResources(in: app_path('Filament/Super/Resources'), for: 'App\\Filament\\Super\\Resources')
            ->discoverWidgets(in: app_path('Filament/Super/Widgets'), for: 'App\\Filament\\Super\\Widgets')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                __('User'),
                __('Management'),
                __('Settings'),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label(__('Profile'))
                    ->url(fn () => route('filament.super.pages.profile'))
                    ->icon('heroicon-o-user'),
                MenuItem::make()
                    ->label(__('Log Out'))
                    ->url(fn () => route('filament.super.auth.logout'))
                    ->icon('heroicon-o-arrow-right-on-rectangle'),
            ])
            ->plugins([
                FilamentLogViewer::make()
                    ->navigationGroup(__('Settings')),
                FilamentEditProfilePlugin::make()
                    ->slug('profile')
                    ->setTitle(__('My Profile'))
                    ->setNavigationLabel(__('My Profile'))
                    ->setNavigationGroup(__('Group Profile'))
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowEmailForm()
                    ->shouldShowLocaleForm(options: [
                        'pt_BR' => __('🇧🇷 Portuguese'),
                        'en' => __('🇺🇸 English'),
                        'es' => __('🇪🇸 Spanish'),
                    ])
                    ->shouldShowThemeColorForm()
                    ->shouldShowSanctumTokens()
                    ->shouldShowMultiFactorAuthentication()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(true, 'attachments'),
                FilamentEvolutionPlugin::make()
                    ->whatsappInstanceResource()  // Show instances (default: true)
                    ->viewMessageHistory()        // Show message history
                    ->viewWebhookLogs(),           // Show webhook logs
            ])
            ->unsavedChangesAlerts()
            ->passwordReset()
            ->profile()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
