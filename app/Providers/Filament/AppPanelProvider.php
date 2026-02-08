<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Adultdate\FilamentBooking\FilamentBookingPlugin;
use AdultDate\FilamentDialer\FilamentDialerPlugin;
use AdultDate\FilamentWirechat\Filament\Pages\ChatDashboard;
use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use Andreia\FilamentUiSwitcher\FilamentUiSwitcherPlugin;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\BookingCalendersX2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\BookingCalendersX4;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\BookingCalendersX6;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\MultiCalendars3 as AppBookingMultiCalendar;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\MultiCalendars3 as Scheman;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\SingleCalendar as AppBookingSinleCalendar;
use App\Filament\App\Pages\AppDashboard;
use App\Filament\App\Pages\AppDataHistory;
use App\Filament\App\Pages\AppRingLista;
use App\Filament\App\Pages\ArbetslistaDashboard;
use App\Filament\App\Pages\Dashboard;
use App\Filament\App\Pages\InertiaCalendar;
use App\Filament\App\Pages\TeamInvitationAccept;
use App\Filament\App\Pages\Tenancy\EditTeamProfile;
// use App\Filament\Data\Resources\RatsitDatas\RatsitDataResource;
use App\Filament\App\Pages\Tenancy\RegisterTeam;
use App\Filament\App\Resources\BookingDataLeads\BookingDataLeadResource;
use App\Filament\App\Resources\RingaDatas\Pages\QueueRingaData;
use App\Filament\App\Resources\TeamUsers\TeamUserResource;
use App\Filament\App\Widgets\RatsitDataStatsWidget;
use App\Http\Middleware\ApplyTenantScopes;
use App\Http\Middleware\CurrentTenant;
use App\Http\Middleware\FilamentPanelAccess;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Team;
use App\Models\User;
use Arshaviras\WeatherWidget\Widgets\WeatherWidget;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Filament\Actions\Action;
use Filament\Enums\ThemeMode;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use JeffersonGoncalves\Filament\RefreshSidebar\RefreshSidebarPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Muazzam\SlickScrollbar\SlickScrollbarPlugin;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use Wallacemartinss\FilamentIconPicker\FilamentIconPickerPlugin;

final class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('nds/app')
            ->login()
            ->authGuard('web')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->passwordReset()
            ->databaseNotifications()
            ->databaseTransactions()
            ->databaseNotificationsPolling('30s')
            ->tenant(Team::class, slugAttribute: 'slug', ownershipRelationship: null)
            ->tenantRoutePrefix('team')
            ->maxContentWidth(Width::Full)
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            ->homeUrl(fn () => Dashboard::getUrl())
            ->sidebarCollapsibleOnDesktop(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->favicon(fn () => asset('favicon.svg'))
            ->brandLogo(fn () => view('filament.app.logo'))
            ->brandLogoHeight(fn () => request()->is('admin/login', 'admin/password-reset/*') ? '68px' : '34px')
            ->viteTheme('resources/css/filament/app/theme.css')
            ->defaultThemeMode(ThemeMode::Dark)
        //    ->discoverClusters(in: app_path('Filament/App/Clusters'), for: 'App\\Filament\\App\\Clusters')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->profile(null)
            ->spa()
            ->registerErrorNotification(
                title: 'Oops! Något gick fel',
                body: 'Vängligen försök igen senare...',
            )
            ->navigationGroups([
                NavigationGroup::make('Kalendrar')
                    ->icon('heroicon-c-squares-plus'),
                NavigationGroup::make('Bokningar Admin')
                    ->icon('heroicon-o-document-text'),
                NavigationGroup::make('Administration')
                    ->icon(Tabler::ShieldCheckF),
                NavigationGroup::make('Mina Sidor')
                    ->icon(Tabler::UserSquareRounded),
            ])
            ->pages([
                AppDashboard::class,
                ChatDashboard::class,
                InertiaCalendar::class,
                AppBookingSinleCalendar::class,
                AppBookingMultiCalendar::class,
                QueueRingaData::class,
                Scheman::class,
                ArbetslistaDashboard::class,
                AppDataHistory::class,
                //    AppRingLista::class,
                //    BookingCalendersX2::class,
                //    BookingCalendersX4::class,
                //    BookingCalendersX2::class,
                //    BookingCalendersX4::class,
                //    BookingCalendersX6::class,
            ])
            ->widgets([
                WeatherWidget::class,
                //    Widgets\AccountWidget::class,
                //    Widgets\FilamentInfoWidget::class,
                //   RatsitDataStatsWidget::class,
            ])
            ->resources([
                //    BookingDataLeadResource::class,
                // RatsitDataResource::class,
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
                //    WeatherWidget::make(),
                SlickScrollbarPlugin::make(),
                FilamentErrorPagesPlugin::make()
                    ->routes([
                        'nds/*',
                        'nds/app/*',
                        'nds/app/team/*',
                    ]),
            ])
            ->plugins([
                //    FilamentShieldPlugin::make(),
            ])
            ->plugins([
                RefreshSidebarPlugin::make(),
                FilamentApexChartsPlugin::make(),
            ])
            ->plugins([
                // ... other plugins
                ResizedColumnPlugin::make()
                    ->preserveOnDB(), // Enable database storage (optional)
            ])
            ->plugins([
                EasyFooterPlugin::make()
                    ->hiddenFromPagesEnabled()
                    ->hiddenFromPages(['sample-page', 'another-page', 'admin/login', 'admin/forgot-password', 'admin/register'])
                    ->withBorder()
                    ->withFooterPosition('sidebar.footer')
                    ->withLogo(
                        'https://static.cdnlogo.com/logos/l/23/laravel.svg', // Path to logo
                        null,                                                // No link
                        null,                                                // No text
                        24                                                   // Logo height in pixels
                    ),
                //    ->withLinks([
                //        ['title' => 'ndsth.com', 'url' => 'https://ndsth.com', 'target' => '_blank'],
                //    ]),
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
            ->plugins([
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
                        'en' => __('🇺🇸 English'),
                        'sv' => __('🇸🇪 Svenska'),
                        'th' => __('🇹🇭 ภาษาไทย'),
                    ])
                    ->shouldShowThemeColorForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowMultiFactorAuthentication()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(true, 'attachments')
                    ->customProfileComponents([
                        \App\Livewire\CustomProfileComponent::class,
                    ]),
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn () => Str::ucfirst(Auth::user()->getNdsUserName()))
                    ->url(fn (): string => EditProfilePage::getUrl(tenant: filament()->getTenant()))
                    ->icon('heroicon-o-user-circle'),
                'wirechat' => Action::make('chats')
                    ->label('Chat')
                    ->url(fn (): string => ChatDashboard::getUrl())
                    ->icon('heroicon-o-chat-bubble-left-right'),

            ])

            ->tenantMiddleware([
                ApplyTenantScopes::class,
                CurrentTenant::class,
            ], isPersistent: true)
            ->tenantMenuItems([

                'register' => fn (Action $action) => $action->label('Register team')
                    ->icon('heroicon-m-user-plus')
                    ->visible(fn () => User::canRegisterTeam() !== false),
                'invitations' => Action::make('invitations')
                    ->label('Team Invitation')
                    ->url(fn (): string => TeamInvitationAccept::getUrl())
                    ->icon('heroicon-m-users')
                    ->visible(fn () => User::canManageTeam() !== false),
                'profile' => fn (Action $action) => $action->label('Edit team profile')
                    ->sort(-1)
                    ->visible(fn () => User::canManageTeam() !== false),
                'team-users' => Action::make('team-users')
                    ->label('Dashboard')
                    ->badge(fn () => now()->timezone('Asia/Bangkok')->format('H:i').' 🇹🇭')
                    ->icon(Remix::RiDashboard2Line)
                    ->url(fn () => TeamUserResource::getUrl())
                    ->sort(-1)
                    ->visible(true),
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
                    )
            )
            ->plugins([
                FilamentBookingPlugin::make(),
                FilamentDialerPlugin::make(),

            ])
            ->plugins([
                FilamentWirechatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
            ])
            ->plugin(FilamentUiSwitcherPlugin::make()
                ->withModeSwitcher());

    }
}
