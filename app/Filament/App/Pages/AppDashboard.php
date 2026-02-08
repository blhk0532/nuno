<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Filament\Admin\Widgets\WorldClockWidget;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Filament\App\Resources\Bookings\Widgets\BookingCalendar;
use App\Filament\App\Widgets\TeamMembersWidget;
use App\Models\BookingCalendar as BookingCalendarModel;
use Arshaviras\WeatherWidget\Widgets\WeatherWidget;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page as BasePage;
use Filament\Panel;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Heroicons;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;

// use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;

final class AppDashboard extends BasePage
{
    use HasFiltersForm;

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'Team';

    //  protected string $view = 'filament.app.dashboard';

    protected static ?int $navigationSort = -1;

    protected static ?int $sort = 1;

    //   protected static string | UnitEnum | null $navigationGroup = '';

    //  protected static string|BackedEnum|null $navigationIcon = Heroicons::OutlinedUserCircle;
    //  protected static string|BackedEnum|null $activeNavigationIcon = Heroicons::SolidUserCircle;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiDashboard2Line;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiDashboard2Fill;

    // Prevent this app-level Dashboard from being auto-discovered so that
    // the explicit `AdminDashboard` can be registered as the admin panel root.
    protected static bool $isDiscovered = false;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        return now()->timezone('Europe/Stockholm')->format('H:i').' 🇸🇪';
        // return (string) (auth()->user()?->name ?? '');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

    public static function getNavigationLabel(): string
    {

        return 'Dashboard';
        //    return (string) (auth()->user()?->name ?? '');
    }

    //  public static function getNavigationBadge(): ?string
    //  {
    //      return 'Online';

    //  }
    //  public static function getNavigationBadgeColor(): ?string
    //  {
    //      return 'success';
    //  }

    //  public static function getNavigationSort(): ?int
    //  {
    //      return -1;
    //  }

    //  public static function getSort(): ?int
    //  {
    //      return -1;
    //  }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('booking_calendars')
                            ->options(fn () => ['all' => 'Show All'] + BookingCalendarModel::pluck('name', 'id')->toArray())
                            ->label('Tekninker')
                            ->placeholder('Välj en tekninker...')
                            ->searchable()
                            ->default('all')
                            ->reactive()
                            ->columnSpan(2)
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        DatePicker::make('startDate')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }

    public function getColumns(): int
    {
        // Use fewer columns so widgets are wider and not visually compressed.
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            BookingCalendar::class,
            \App\Filament\App\Widgets\StatsOverviewWidget::class,

            \App\Filament\App\Widgets\OrdersChart::class,
            \App\Filament\App\Widgets\CustomersChart::class,
            //     \App\Filament\App\Widgets\BookingStats::class,
        ];
    }

    public function getHeaderWidgets(): array
    {

        return [
            AccountInfoStackWidget::class,
            WorldClockWidget::class,
            TeamMembersWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {

        return [
            WeatherWidget::class,
            //    MultiCalendar2::class,
            //    MultiCalendar3::class,
            //    \App\Filament\App\Widgets\LatestOrders::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderTitle(): string
    {
        return '';
    }
}
