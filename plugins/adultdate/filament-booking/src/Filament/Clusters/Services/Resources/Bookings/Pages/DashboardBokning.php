<?php

namespace Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Pages;

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
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Models\BookingCalendar as BookingCalendarModel;
use App\UserRole;
use Filament\Support\Enums\Width;
use Adultdate\FilamentBooking\Filament\Widgets\FilamentInfosWidget;
use Adultdate\FilamentBooking\Filament\Widgets\AccountWidget;
use Adultdate\FilamentBooking\Filament\Widgets\FullCalendarWidget;
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiEventCalendar;

class DashboardBokning extends BaseDashboard
{


    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

//    protected static ?string $navigationLabel = 'Dash';

     protected static ?string $title = '';

    protected static string $routePath = 'service/bokning';

  //  protected static ?string $slug = 'dashboard';

        protected string $view = 'filament-booking::pages.page';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }



    public static function getNavigationLabel(): string
    {
        return '' . Str::ucfirst('Bokning') ?? 'User';
    }

    public static function getNavigationBadge(): ?string
    {
          return now()->timezone('Europe/Stockholm')->format('H:i');

    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }


    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('booking_calendars_1')
                            ->options(fn () => BookingCalendarModel::pluck('name', 'id')->toArray())
                            ->label('Tekninker Calendar 1')
                            ->placeholder('Select Tekniker for Calendar 1')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_2')
                            ->options(fn () => BookingCalendarModel::pluck('name', 'id')->toArray())
                            ->label('Tekninker Calendar 2')
                            ->placeholder('Select Tekniker for Calendar 2')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function () {
                                $this->dispatch('refreshCalendar');
                            }),
                        Select::make('booking_calendars_3')
                            ->options(fn () => BookingCalendarModel::pluck('name', 'id')->toArray())
                            ->label('Tekninker Calendar 3')
                            ->placeholder('Select Tekniker for Calendar 3')
                            ->searchable()
                            ->reactive()
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

public function getWidgets(): array
    {
        return [
                MultiCalendar1::class,
                MultiCalendar2::class,
                MultiCalendar3::class,

        ];
    }

}
