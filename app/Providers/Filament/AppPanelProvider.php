<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Adultdate\FilamentBooking\FilamentBookingPlugin;
use AdultDate\FilamentWirechat\Filament\Pages\ChatDashboard;
use AdultDate\FilamentWirechat\FilamentWirechatPlugin;
use Andreia\FilamentUiSwitcher\FilamentUiSwitcherPlugin;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\DashboardBokning as AppBookingMultiCalendar;
use App\Filament\App\Clusters\Services\Resources\Bookings\Pages\DashboardBooking as AppBookingSinleCalendar;
use App\Filament\App\Pages\InertiaCalendar;
use App\Filament\App\Pages\TeamInvitationAccept;
use App\Filament\App\Pages\Tenancy\EditTeamProfile;
use App\Filament\App\Pages\Tenancy\RegisterTeam;
use App\Filament\App\Resources\BookingDataLeads\BookingDataLeadResource;
use App\Http\Middleware\ApplyTenantScopes;
use App\Http\Middleware\CurrentTenant;
use App\Http\Middleware\FilamentPanelAccess;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Team;
use App\Models\User;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
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
use Filament\View\PanelsRenderHook;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
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
            ->tenant(Team::class, slugAttribute: 'slug')
            ->tenantRoutePrefix('team')
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            ->sidebarCollapsibleOnDesktop(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->favicon(fn () => asset('favicon.svg'))
            ->brandLogo(fn () => view('filament.app.logo'))
            ->brandLogoHeight(fn () => request()->is('admin/login', 'admin/password-reset/*') ? '68px' : '34px')
            ->viteTheme('resources/css/filament/app/theme.css')
            ->defaultThemeMode(config('teamkit.theme_mode', ThemeMode::Dark))
        //    ->discoverClusters(in: app_path('Filament/App/Clusters'), for: 'App\\Filament\\App\\Clusters')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->navigationGroups([
                NavigationGroup::make('Kalendrar')
                    ->icon('heroicon-m-calendar-days'),
                NavigationGroup::make('Mina Sidor')
                    ->icon('heroicon-o-identification'),
            ])
            ->pages([
                ChatDashboard::class,
                InertiaCalendar::class,
                AppBookingSinleCalendar::class,
                AppBookingMultiCalendar::class,
            ])
            ->widgets([
                //    Widgets\AccountWidget::class,
                //    Widgets\FilamentInfoWidget::class,
            ])
            ->resources([
                //    BookingDataLeadResource::class,
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
                FilamentApexChartsPlugin::make(),
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
            ->plugin(FilamentUiSwitcherPlugin::make()
                ->iconRenderHook(PanelsRenderHook::TOPBAR_LOGO_AFTER))
            ->plugins([
                FilamentIconPickerPlugin::make(),
                FilamentBookingPlugin::make(),
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
            ])
            ->plugins([
                FilamentWirechatPlugin::make()
                    ->onlyPages([])
                    ->excludeResources([
                        \AdultDate\FilamentWirechat\Filament\Resources\Conversations\ConversationResource::class,
                        \AdultDate\FilamentWirechat\Filament\Resources\Messages\MessageResource::class,
                    ]),
            ])

            ->userMenuItems([
                'wirechat' => Action::make('wirechat')
                    ->label(fn (): string => __('Chats'))
                    ->url(fn (): string => ChatDashboard::getUrl())
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->visible(fn () => Filament::getTenant() !== null),
                'profile' => Action::make('profile')
                    ->label(fn (): string => __('Profile'))
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),

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
                    ->visible(fn () => Filament::getTenant() !== null),
                'profile' => fn (Action $action) => $action->label('Edit team profile')
                    ->visible(fn () => User::canManageTeam() !== false),
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
            );
    }
}
