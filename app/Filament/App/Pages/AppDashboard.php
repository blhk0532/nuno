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
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;

// use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;

final class AppDashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $title = '';

    protected static ?string $slug = 'dashboard';

    protected string $view = 'filament.app.dashboard';

    //    protected static string | UnitEnum | null $navigationGroup = 'Mina Sidor';

    protected static ?int $navigationSort = 0;

    protected static ?int $sort = 0;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-identification';

    // Prevent this app-level Dashboard from being auto-discovered so that
    // the explicit `AdminDashboard` can be registered as the admin panel root.
    protected static bool $isDiscovered = true;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return ''.Str::ucfirst(Auth::user()->name) ?? 'User';
    }

    public static function getNavigationBadge(): ?string
    {
        return 'Online';

    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-m-identification';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getSort(): ?int
    {
        return 2;
    }

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
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('show_all_bookings')
                            ->options([true => 'Ja', false => 'Nej'])
                            ->label('Filtrera Bokningar')
                            ->placeholder('Endast mina bok?')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('show_all_day_events')
                            ->options([true => 'Ja', false => 'Nej'])
                            ->label('Visa heldags händelser')
                            ->placeholder('Visa heldags?')
                            ->default(true)
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        DatePicker::make('startDate')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(5)
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
        return false;
    }
}
