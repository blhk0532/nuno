<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Filament\Admin\Widgets\WorldClockWidget;
use App\Filament\App\Resources\Bookings\Widgets\BookingCalendar;
use App\Models\BookingCalendar as BookingCalendarModel;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page as BasePage;
use Filament\Panel;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

final class ArbetslistaDashboard extends BasePage
{
    use HasFiltersForm;

    protected static ?string $title = 'Arbetslista';

    protected static ?string $slug = 'arbetslista';

    protected static ?string $navigationLabel = 'NDSนอร์ดิก';

    //  protected string $view = 'filament.app.dashboard';

    protected static ?int $navigationSort = 4;

    protected static ?int $sort = 4;

    //   protected static string | UnitEnum | null $navigationGroup = ' ';

    //  protected static string|BackedEnum|null $navigationIcon = Heroicons::OutlinedUserCircle;
    //  protected static string|BackedEnum|null $activeNavigationIcon = Heroicons::SolidUserCircle;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiGroup3Line;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiGroup3Fill;

    // Prevent this app-level Dashboard from being auto-discovered so that
    // the explicit `AdminDashboard` can be registered as the admin panel root.
    protected static bool $isDiscovered = true;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return 'GROUP';
        // return  now()->timezone('Asia/Bangkok')->format('H:i') . ' 🇹🇭 ';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    //  public static function getNavigationLabel(): string
    //  {
    //      return ''.Str::ucfirst(Auth::user()->name) ?? 'User';
    //  }

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
        ];
    }

    public function getFooterWidgets(): array
    {

        return [
            \App\Filament\App\Widgets\LatestOrders::class,
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
