<?php

namespace App\Filament\App\Resources\Bookings\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use BackedEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\App\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Resources\Bookings\Widgets\MultiCalendar3;
use App\Models\BookingCalendar as BookingCalendarModel;
use App\UserRole;
use Filament\Support\Enums\Width;
use Adultdate\FilamentBooking\Filament\Widgets\FilamentInfosWidget;
use Adultdate\FilamentBooking\Filament\Widgets\AccountWidget;
use Adultdate\FilamentBooking\Filament\Widgets\FullCalendarWidget;
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiEventCalendar;
use UnitEnum;
class DashboardBokning extends BaseDashboard
{


    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-calendar-days';

//    protected static ?string $navigationLabel = 'Dash';

     protected static ?string $title = '';

    protected static string $routePath = 'dashboard';

    protected static string|UnitEnum|null $navigationGroup = '';

    protected static ?string $slug = 'dashboard';

        protected string $view = 'filament-booking::pages.page';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }



    public static function getNavigationLabel(): string
    {
        return '' . Str::ucfirst('Kalender') ?? 'User';
    }

    public static function getNavigationBadge(): ?string
    {
          return 'x3';

    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
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
                            ->reactive()
                            ->default($calendarIds[0] ?? null)
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_2')
                            ->options($calendarOptions)
                            ->label('#2 ◴ Tekninker')
                            ->placeholder('Select Tekniker for Calendar 2')
                            ->searchable()
                            ->reactive()
                            ->default($calendarIds[1] ?? null)
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_3')
                            ->options($calendarOptions)
                            ->label('#3 ◴ Tekniker')
                            ->placeholder('Select Tekniker for Calendar 3')
                            ->searchable()
                            ->reactive()
                            ->default($calendarIds[2] ?? null)
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            })
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function getPermissionCheckClosure(): \Closure
    {
        return fn (string $widgetClass) => true;
    }


public function getMaxContentWidth(): Width
{
    return Width::Full;
}


public function getHeaderWidgetsColumns(): int | array
{
    return 3;
}

public function getWidgetsColumns(): int | array
{
    return 3;
}

public function getColumns(): int | array
{
    return 3;
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

        ];
    }

}
