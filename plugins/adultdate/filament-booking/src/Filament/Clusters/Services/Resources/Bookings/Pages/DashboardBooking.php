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
use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar;
use App\Models\BookingCalendar as BookingCalendarModel;
use App\UserRole;
use Filament\Support\Enums\Width;
use Filament\Navigation\Sidebar;

class DashboardBooking extends BaseDashboard
{

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    protected static ?string $navigationLabel = 'Dash';

     protected static ?string $title = '';

        protected static ?int $navigationSort = -1;

        protected static ?int $sort = -1;

    protected static string $routePath = 'service/booking';


     use HasFiltersForm;
  //  protected static ?string $slug = 'dashboard';

        protected string $view = 'filament-booking::pages.page';


    public function mount(): void
    {
        $this->dispatch('filament-collapse-sidebar');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

        public function getWidgets(): array
    {
        return [
                BookingCalendar::class,
        ];
    }

public function getMaxContentWidth(): Width
{
    return Width::Full;
}

    public static function getNavigationLabel(): string
    {
        return '' . Str::ucfirst('Bokning Kalender') ?? 'Bokning Kalender';
    }

    public static function getNavigationBadge(): ?string
    {
        //  return now()->format('H:m');
     return 'x1';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

                public static function getNavigationSort(): ?int
    {
        return -1;
    }

                public static function getSort(): ?int
    {
        return -1;
    }



    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('booking_calendars')
                            ->options(fn () => BookingCalendarModel::pluck('name', 'id')->toArray())
                            ->label('Tekninker')
                            ->placeholder('Select a calendar owner')
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
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function getPermissionCheckClosure(): \Closure
    {
        return fn (string $widgetClass) => true;
    }


}
