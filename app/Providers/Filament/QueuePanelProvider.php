<?php

namespace App\Providers\Filament;

use App\Http\Middleware\FilamentPanelAccess;

use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
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
use App\Filament\Queue\Pages\QueueDashboard;
use Bytexr\QueueableBulkActions\Enums\StatusEnum;
use Bytexr\QueueableBulkActions\QueueableBulkActionsPlugin;
use BinaryBuilds\FilamentFailedJobs\FilamentFailedJobsPlugin;
use Adultdate\FilamentBooking\Filament\Resources\BookingCalendars\BookingCalendarResource;
use Adultdate\FilamentBooking\Filament\Resources\BookingDataLeads\BookingDataLeadResource;
class QueuePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('queue')
            ->path('nds/queue')
            ->viteTheme('resources/css/filament/queue/theme.css')
            ->colors([
                'primary' => Color::Gray,
            ])
            ->spa()
            // ->profile()
            ->passwordReset()
            ->unsavedChangesAlerts()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->sidebarCollapsibleOnDesktop(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->brandLogoHeight('34px')
            ->favicon(fn() => asset('favicon.svg'))
            ->brandLogo(fn() => view('filament.app.logo'))
            ->plugin(
                AuthDesignerPlugin::make()
                    ->login(
                        fn(AuthPageConfig $config) => $config
                            ->media(asset('assets/bangkok.jpg'))
                            ->mediaPosition(MediaPosition::Cover)
                            ->blur(1)
                            ->themeToggle()
                            ->renderHook(AuthDesignerRenderHook::CardBefore, fn() => view('filament.logo-auth'))
                    ),
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
            ->discoverResources(in: app_path('Filament/Queue/Resources'), for: 'App\Filament\Queue\Resources')
            ->discoverPages(in: app_path('Filament/Queue/Pages'), for: 'App\Filament\Queue\Pages')
            ->discoverResources(in: app_path('Filament/Panels/Resources'), for: 'App\Filament\Panels\Resources')
            ->pages([
                QueueDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Queue/Widgets'), for: 'App\Filament\Queue\Widgets')
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
            ->resources([
                BookingCalendarResource::class,
                BookingDataLeadResource::class,
            ])
            ->plugins([
                FilamentFailedJobsPlugin::make(),
                QueueableBulkActionsPlugin::make()
                    ->pollingInterval('5s')
                    ->colors([
                        StatusEnum::QUEUED->value => 'slate',
                        StatusEnum::IN_PROGRESS->value => 'info',
                        StatusEnum::FINISHED->value => 'success',
                        StatusEnum::FAILED->value => 'danger',
                    ]),
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
