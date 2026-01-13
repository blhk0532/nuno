<?php

namespace App\Providers\Filament;

use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use App\Filament\Admin\Pages\Auth\Login;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Wallacemartinss\FilamentIconPicker\FilamentIconPickerPlugin;

class BookingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('booking')
            ->path('booking')
            ->viteTheme('resources/css/filament/booking/theme.css')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(
                AuthDesignerPlugin::make()
                    ->login(
                        fn (AuthPageConfig $config) => $config
                            ->media(asset('assets/bangkok.jpg'))
                            ->mediaPosition(MediaPosition::Cover)
                            ->blur(1)
                            ->themeToggle()
                            ->renderHook(AuthDesignerRenderHook::CardBefore, fn () => view('filament.logo-auth'))
                    ),
                FilamentWireChatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
                FilamentIconPickerPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
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
            )
            ->discoverResources(in: app_path('Filament/Booking/Resources'), for: 'App\Filament\Booking\Resources')
            ->discoverPages(in: app_path('Filament/Booking/Pages'), for: 'App\Filament\Booking\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Booking/Widgets'), for: 'App\Filament\Booking\Widgets')
            ->widgets([
                //    AccountWidget::class,
                //    FilamentInfoWidget::class,
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

