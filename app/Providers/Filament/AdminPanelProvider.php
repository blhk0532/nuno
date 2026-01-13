<?php

namespace App\Providers\Filament;

use AchyutN\FilamentLogViewer\FilamentLogViewer;
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Pages\DashboardBooking;
use Adultdate\FilamentBooking\Filament\Pages\CalendarSettingsPage;
use Adultdate\FilamentBooking\Filament\Resources\Booking\BookingOutcallQueues\BookingOutcallQueueResource;
use Adultdate\FilamentBooking\Filament\Resources\Booking\Customers\CustomerResource;
use Adultdate\FilamentBooking\Filament\Resources\Booking\DailyLocations\DailyLocationResource;
use Adultdate\FilamentBooking\Filament\Resources\Booking\DailyLocations\Widgets\EventCalendar;
use Adultdate\FilamentBooking\Filament\Resources\Booking\Orders\OrderResource;
use Adultdate\FilamentBooking\Filament\Resources\Booking\ServicePeriods\BookingServicePeriodResource;
use Adultdate\FilamentBooking\Filament\Resources\Booking\Users\UserResource;
use Adultdate\FilamentBooking\Filament\Resources\BookingCalendars\BookingCalendarResource;
use Adultdate\FilamentBooking\Filament\Resources\BookingDataLeads\BookingDataLeadResource;
use Adultdate\FilamentBooking\Filament\Widgets\BookingCalendarWidget;
use Adultdate\FilamentBooking\Filament\Widgets\CustomersChart;
use Adultdate\FilamentBooking\Filament\Widgets\LatestOrders;
use Adultdate\FilamentBooking\Filament\Widgets\OrdersChart;
use Adultdate\FilamentBooking\Filament\Widgets\StatsOverviewWidget;
use Adultdate\FilamentBooking\FilamentBookingPlugin;
use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use App\Models\User;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BinaryBuilds\CommandRunner\CommandRunnerPlugin;
use BinaryBuilds\FilamentCacheManager\FilamentCacheManagerPlugin;
use BinaryBuilds\FilamentFailedJobs\FilamentFailedJobsPlugin;
use Bytexr\QueueableBulkActions\Enums\StatusEnum;
use Bytexr\QueueableBulkActions\QueueableBulkActionsPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Filament\Actions\Action;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use lockscreen\FilamentLockscreen\Lockscreen;
use MWGuerra\FileManager\Filament\Pages\FileManager;
use MWGuerra\FileManager\Filament\Pages\FileSystem;
use MWGuerra\FileManager\Filament\Pages\SchemaExample;
use MWGuerra\FileManager\Filament\Resources\FileSystemItemResource;
use MWGuerra\FileManager\FileManagerPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use Usamamuneerchaudhary\Notifier\FilamentNotifierPlugin;
use WallaceMartinss\FilamentEvolution\FilamentEvolutionPlugin;
use Wallacemartinss\FilamentIconPicker\FilamentIconPickerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
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
            ->registration(false)
            ->passwordReset()
            ->emailVerification(false)
            ->emailChangeVerification()
            ->spa()

            ->navigationGroups([
                NavigationGroup::make('Account')
                    ->icon('heroicon-o-user-circle'),
            ])

            ->defaultThemeMode(config('teamkit.theme_mode', ThemeMode::Dark))

            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\\Filament\\Admin\\Clusters')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')

            ->discoverClusters(in: app_path('../plugins/adultdate/filament-booking/src/Filament/Clusters'), for: 'Adultdate\\FilamentBooking\\Filament\\Clusters')
            ->discoverResources(in: app_path('../plugins/adultdate/filament-booking/src/Filament/Resources'), for: 'Adultdate\\FilamentBooking\\Filament\\Resources')

            ->pages([
            //    Pages\Dashboard::class,
                DashboardBooking::class,
                CalendarSettingsPage::class,
            ])
            ->resources([
                BookingCalendarResource::class,
            ])

            ->resources([
                CustomerResource::class,
                OrderResource::class,
                DailyLocationResource::class,
                BookingServicePeriodResource::class,
                BookingOutcallQueueResource::class,
                UserResource::class,
                BookingCalendarResource::class,
                BookingDataLeadResource::class,
            ])
            ->widgets([
                BookingCalendarWidget::class,
                CustomersChart::class,
                LatestOrders::class,
                OrdersChart::class,
                StatsOverviewWidget::class,
                EventCalendar::class,
            ])

            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                OverlookWidget::class,
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
                FilamentExceptionsPlugin::make(),
            ])
            ->plugin(
                FilamentCacheManagerPlugin::make()
                    ->canAccessPlugin(function () {
                        $user = Auth::user();

                        return $user instanceof User && $user->hasRole('super_admin');
                    })
            )
            ->plugins([
                QueueableBulkActionsPlugin::make()
                    ->pollingInterval('5s')
                    ->colors([
                        StatusEnum::QUEUED->value => 'slate',
                        StatusEnum::IN_PROGRESS->value => 'info',
                        StatusEnum::FINISHED->value => 'success',
                        StatusEnum::FAILED->value => 'danger',
                    ]),
            ])
            ->plugin(CommandRunnerPlugin::make())

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
                        'pt_BR' => __('🇧🇷 Portuguese'),
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
                FileManagerPlugin::make([
                    FileManager::class,              // Database mode - full CRUD file manager
                    FileSystem::class,               // Storage mode - read-only file browser
                    FileSystemItemResource::class,   // Resource for direct database table editing
                    SchemaExample::class,            // Demo page showing embed components usage
                ]),
                FilamentSpatieLaravelBackupPlugin::make(),
                SpotlightPlugin::make(),
                ResizedColumnPlugin::make(),
                FilamentFailedJobsPlugin::make(),
                FilamentIconPickerPlugin::make(),
                FilamentLogViewer::make()
                    ->navigationGroup(__('Settings')),
                FilamentEvolutionPlugin::make()
                    ->whatsappInstanceResource()  // Show instances (default: true)
                    ->viewMessageHistory()        // Show message history
                    ->viewWebhookLogs(),           // Show webhook logs
                FilamentBookingPlugin::make(),
            ])
            ->plugins([
                FilamentNotifierPlugin::make(),
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
                Action::make('switch_panels')
                    ->label('Switch View')
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->color('gray')
                    ->modalHeading('Switch Panels')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->sort(-1)
                    ->modalContent(function () {
                        $user = Auth::user();
                        $panels = collect(filament()->getPanels())->filter(function ($panel) use ($user) {
                            return $user instanceof User && $user->canAccessPanel($panel);
                        });

                        return view('switch-panels-modal', ['panels' => $panels]);
                    }),
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
                FilamentWireChatPlugin::make(),
            ])
            ->unsavedChangesAlerts()
            ->passwordReset()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
