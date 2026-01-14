<?php

namespace App\Providers\Filament;

use App\Http\Middleware\FilamentPanelAccess;
use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use AchyutN\FilamentLogViewer\FilamentLogViewer;
use Filament\Enums\ThemeMode;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
use App\Filament\Super\Pages\SuperDashboard;

class SuperPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('super')
            ->path('nds/super')
            ->login()
           // ->authGuard('super')
            ->colors([
                'primary' => Color::Gray,
            ])
            ->brandLogoHeight('36px')
            ->unsavedChangesAlerts()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->sidebarCollapsibleOnDesktop(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
             ->brandLogo(fn () => view('filament.app.logo'))
            ->viteTheme('resources/css/filament/super/theme.css')
            ->defaultThemeMode(config('teamkit.theme_mode', ThemeMode::Dark))
            ->discoverClusters(in: app_path('Filament/Super/Clusters'), for: 'App\\Filament\\Super\\Clusters')
            ->discoverPages(in: app_path('Filament/Super/Pages'), for: 'App\\Filament\\Super\\Pages')
            ->discoverResources(in: app_path('Filament/Super/Resources'), for: 'App\\Filament\\Super\\Resources')
            ->discoverWidgets(in: app_path('Filament/Super/Widgets'), for: 'App\\Filament\\Super\\Widgets')
            ->discoverResources(in: app_path('Filament/Panels/Resources'), for: 'App\Filament\Panels\Resources')
            ->pages([
                SuperDashboard::class,
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
                FilamentPanelAccess::class,
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
                Action::make('profile')
                    ->label(__('Profile'))
                    ->url(fn () => route('filament.super.pages.profile'))
                    ->icon('heroicon-o-user'),
                Action::make('logout')
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
            ->plugins([
                FilamentWireChatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
            ]);
    }
}
