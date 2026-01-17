<?php

namespace App\Providers\Filament;

use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use App\Http\Middleware\FilamentPanelAccess;
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
use App\Filament\Booking\Pages\GoogleCalendar;
use App\Filament\Booking\Pages\InertiaCalendar;
use App\Filament\Booking\Pages\BookingDashboard;
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
use Filament\Navigation\Sidebar;
class BookingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('booking')
            ->path('nds/booking')
            ->viteTheme('resources/css/filament/booking/theme.css')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Gray,
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
            ->brandName('Noridic Digital')
            ->sidebarCollapsibleOnDesktop(true)
            ->databaseNotifications()
            ->databaseTransactions()
            ->databaseNotificationsPolling('30s')
            ->brandLogo(fn () => view('filament.app.logo'))
            ->favicon(fn () => asset('favicon.svg'))
            ->brandLogoHeight(fn () => request()->is('admin/login', 'admin/password-reset/*') ? '68px' : '34px')
            ->discoverResources(in: app_path('Filament/Booking/Resources'), for: 'App\Filament\Booking\Resources')
            ->discoverResources(in: app_path('Filament/Panels/Resources'), for: 'App\Filament\Panels\Resources')
            ->discoverPages(in: app_path('Filament/Booking/Pages'), for: 'App\Filament\Booking\Pages')
            ->discoverClusters(in: app_path('Filament/Booking/Clusters'), for: 'App\\Filament\\Booking\\Clusters')

            ->pages([
            //   Dashboard::class,
                GoogleCalendar::class,
                InertiaCalendar::class,
            //    BookingDashboard::class,
            ])

            ->pages([
            //    Pages\Dashboard::class,
            //    DashboardBooking::class,
                CalendarSettingsPage::class,
            ])
            ->resources([
                BookingCalendarResource::class,
            ])

            ->resources([
                DailyLocationResource::class,
                BookingServicePeriodResource::class,
                UserResource::class,
            ])
            ->widgets([
                BookingCalendarWidget::class,
                CustomersChart::class,
                LatestOrders::class,
                OrdersChart::class,
                StatsOverviewWidget::class,
                EventCalendar::class,
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
                FilamentPanelAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentBookingPlugin::make(),
                FilamentWireChatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
            ]);
    }
}

