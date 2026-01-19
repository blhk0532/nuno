<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Bookings\Pages;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar4;
use App\Models\BookingCalendar as BookingCalendarModel;
use BackedEnum;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use UnitEnum;

final class BookingCalendersX4 extends BaseDashboard
{
    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    //    protected static ?string $navigationLabel = 'Dash';

    protected static ?string $title = '';

    protected static string $routePath = 'nds-kalender-x4';

    protected static ?int $navigationSort = 4;

    //  protected static ?string $slug = 'dashboard';

    protected static string|UnitEnum|null $navigationGroup = 'Kalendrar';

    protected string $view = 'filament-booking::pages.page';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return ''.Str::ucfirst('NDS Kalender x4') ?? 'NDS Kalender x4';
    }

    public static function getNavigationBadge(): ?string
    {
        return 'x4';

    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

        public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function getSort(): ?int
    {
        return 4;
    }

    public function filtersForm(Schema $schema): Schema
    {
        $calendarOptions = BookingCalendarModel::pluck('name', 'id')->toArray();
        $calendarIds = array_keys($calendarOptions);

        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('booking_calendars_1')
                            ->options($calendarOptions)
                            ->label('#1 ◴ Tekninker')
                            ->placeholder('Select Tekniker for Calendar 1')
                            ->searchable()
                            ->live()
                            ->default($calendarIds[0] ?? null)
                            ->afterStateUpdated(function ($state) {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_2')
                            ->options($calendarOptions)
                            ->label('#2 ◴ Tekninker')
                            ->placeholder('Select Tekniker for Calendar 2')
                            ->searchable()
                            ->live()
                            ->default($calendarIds[1] ?? null)
                            ->afterStateUpdated(function ($state) {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_3')
                            ->options($calendarOptions)
                            ->label('#3 ◴ Tekniker')
                            ->placeholder('Select Tekniker for Calendar 3')
                            ->searchable()
                            ->live()
                            ->default($calendarIds[2] ?? null)
                            ->afterStateUpdated(function ($state) {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_4')
                            ->options($calendarOptions)
                            ->label('#4 ◴ Tekniker')
                            ->placeholder('Select Tekniker for Calendar 4')
                            ->searchable()
                            ->live()
                            ->default($calendarIds[2] ?? null)
                            ->afterStateUpdated(function ($state) {
                                $this->dispatch('refreshCalendar');
                            }),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }

    public function getPermissionCheckClosure(): Closure
    {
        return fn (string $widgetClass) => true;
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 2;
    }

    public function getWidgetsColumns(): int|array
    {
        return 2;
    }

    public function getColumns(): int|array
    {
        return 2;
    }

    public function getHeaderWidgets(): array
    {
        return [

        ];
    }

    public function getWidgets(): array
    {
        return [
            MultiCalendar1::class,
            MultiCalendar2::class,
            MultiCalendar3::class,
            MultiCalendar4::class,
        ];
    }
}
