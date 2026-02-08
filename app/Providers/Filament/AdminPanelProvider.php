<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Adultdate\FilamentBooking\Filament\Resources\BookingCalendars\BookingCalendarResource;
use Adultdate\FilamentBooking\FilamentBookingPlugin;
use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use AlizHarb\ActivityLog\ActivityLogPlugin;
use AlizHarb\ActivityLog\Widgets\LatestActivityWidget;
use Andreia\FilamentUiSwitcher\FilamentUiSwitcherPlugin;
use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Http\Middleware\FilamentPanelAccess;
use App\Models\User;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Devtical\Sanctum\Pages\Sanctum;
use Filament\Actions\Action;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use JeffersonGoncalves\Filament\WhatsappWidget\Resources\WhatsappAgentResource;
use JeffersonGoncalves\Filament\WhatsappWidget\WhatsappWidgetPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use lockscreen\FilamentLockscreen\Lockscreen;
use WallaceMartinss\FilamentEvolution\FilamentEvolutionPlugin;
use Wallacemartinss\FilamentIconPicker\FilamentIconPickerPlugin;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('nds/admin')
            ->login()
            ->authGuard('web')
            ->colors([
                'primary' => Color::Orange,
            ])
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(fn () => view('filament.app.logo'))
            ->favicon(fn () => asset('favicon.svg'))
            ->brandLogoHeight(fn () => request()->is('admin/login', 'admin/password-reset/*') ? '68px' : '34px')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName('Noridic Digital')
            ->defaultThemeMode(ThemeMode::Dark)
            ->revealablePasswords(true)
            ->passwordReset()
            ->emailChangeVerification()
            ->spa()
            ->navigationGroups([
                NavigationGroup::make('Boknings Kalendrar')
                    ->icon('heroicon-o-calendar-days'),
            ])

            ->defaultThemeMode(config('teamkit.theme_mode', ThemeMode::Dark))

            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\\Filament\\Admin\\Clusters')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
        //    ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')

            //            ->discoverResources(in: app_path('../plugins/adultdate/filament-booking/src/Filament/Resources'), for: 'Adultdate\\FilamentBooking\\Filament\\Resources')

            ->pages([
                Sanctum::class,
            ])
            ->resources([
                BookingCalendarResource::class,
                WhatsappAgentResource::class,
            ])
            ->widgets([
                //    AccountInfoStackWidget::class,
                //    OverlookWidget::class,
                //    LatestActivityWidget::class,
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
            ->plugins([
                FilamentApexChartsPlugin::make(),
                FilamentEvolutionPlugin::make(),
            ])
            ->plugins([
                FilamentGeneralSettingsPlugin::make()
                    ->canAccess(fn () => Auth::user()->role === 'super')
                    ->setSort(3)
                    ->setIcon('heroicon-o-cog')
                    ->setNavigationGroup('Settings')
                    ->setTitle('Settings')
                    ->setNavigationLabel('Settings'),
            ])
            ->plugins([

            ])
            ->plugins([
                OverlookPlugin::make()
                    ->sort(2)
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 5,
                        '2xl' => null,
                    ]),
            ])
            ->plugins([
                WhatsappWidgetPlugin::make(),
            ])
            ->plugins([
                ActivityLogPlugin::make()
                    ->label('Log')
                    ->pluralLabel('Logs')
                    ->navigationGroup('System'),
            ])
            ->plugins([
                EasyFooterPlugin::make()
                    ->hiddenFromPagesEnabled()
                    ->hiddenFromPages(['sample-page', 'another-page', 'admin/login', 'admin/forgot-password', 'admin/register'])
                    ->withBorder()
                    ->withLoadTime()
                    ->withLogo(
                        'https://static.cdnlogo.com/logos/l/23/laravel.svg', // Path to logo
                        null,                                                // No link
                        null,                                                // No text
                        24                                                   // Logo height in pixels
                    )
                    ->withLinks([
                        ['title' => 'ndsth.com', 'url' => 'https://ndsth.com', 'target' => '_blank'],
                    ]),
            ])
            ->plugin(
                AuthDesignerPlugin::make()
                    ->login(
                        fn (AuthPageConfig $config) => $config
                            ->media(asset('assets/background.jpg'))
                            ->mediaPosition(MediaPosition::Cover)
                            ->blur(1)
                            ->themeToggle()
                            ->renderHook(AuthDesignerRenderHook::CardBefore, fn () => view('filament.logo-auth'))
                    )
            )
            ->plugins([
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
                        'en' => __('🇺🇸 English'),
                        'es' => __('🇪🇸 Spanish'),
                    ])
                    ->shouldShowThemeColorForm()
                    ->shouldShowSanctumTokens()
                    ->shouldShowMultiFactorAuthentication()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(true, 'attachments'),
                Lockscreen::make()
                    ->enableRateLimit() // Enable rate limit for the lockscreen. Default: Enable, 5 attempts in 1 minute.
                    ->enableIdleTimeout() // Enable auto lock during idle time. Default: Enable, 30 minutes.
                    ->disableDisplayName() // Display the name of the user based on the attribute supplied. Default: name
                    ->enablePlugin(), // Enable the plugin.
            ])
            ->plugins([
                ResizedColumnPlugin::make(),
                FilamentIconPickerPlugin::make(),
                Lockscreen::make()
                    ->enableRateLimit() // Enable rate limit for the lockscreen. Default: Enable, 5 attempts in 1 minute.
                    ->enableIdleTimeout() // Enable auto lock during idle time. Default: Enable, 30 minutes.
                    ->disableDisplayName() // Display the name of the user based on the attribute supplied. Default: name
                    ->enablePlugin(), // Enable the plugin.
            ])
            ->plugins([
                FilamentBookingPlugin::make(),
            ])
            ->plugins([
                TableLayoutTogglePlugin::make()
                    ->setDefaultLayout('grid') // default layout for user seeing the table for the first time
                    ->persistLayoutUsing(
                        persister: \Hydrat\TableLayoutToggle\Persisters\LocalStoragePersister::class, // chose a persister to save the layout preference of the user
                        cacheStore: 'redis', // optional, change the cache store for the Cache persister
                        cacheTtl: 60 * 24, // optional, change the cache time for the Cache persister
                    )
                    ->shareLayoutBetweenPages(false) // allow all tables to share the layout option for this user
                    ->displayToggleAction() // used to display the toggle action button automatically
                    ->toggleActionHook('tables::toolbar.search.after') // chose the Filament view hook to render the button on
                    ->listLayoutButtonIcon('heroicon-o-list-bullet')
                    ->gridLayoutButtonIcon('heroicon-o-squares-2x2'),
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn () => Str::ucfirst(Auth::user()->getNdsUserName()))
                    ->url(fn (): string => EditProfilePage::getUrl(tenant: filament()->getTenant()))
                    ->icon('heroicon-o-user-circle'),
                Action::make('sanctum')
                    ->label(trans('Auth Tokens'))
                    ->url('/nds/admin/'.config('filament-sanctum.navigation.slug'))
                    ->icon(config('filament-sanctum.navigation.icon', 'heroicon-o-finger-print')),
            ])
            ->plugin(
                FilamentShieldPlugin::make()
                    ->navigationLabel('Roles')                  // string|Closure|null
                    ->navigationIcon('heroicon-o-shield-check')         // string|Closure|null
                    ->activeNavigationIcon('heroicon-s-shield-check')   // string|Closure|null
                    ->navigationGroup('Användare')                  // string|Closure|null
                    ->navigationSort(10)                        // int|Closure|null
                    ->navigationBadge('Roles')                      // string|Closure|null
                    ->navigationBadgeColor('success')           // string|array|Closure|null
            )
            ->plugins([
                FilamentWirechatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
            ])
            ->plugin(FilamentUiSwitcherPlugin::make()
                ->withModeSwitcher()
                ->iconRenderHook(PanelsRenderHook::USER_MENU_BEFORE))
            ->unsavedChangesAlerts()
            ->passwordReset()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
