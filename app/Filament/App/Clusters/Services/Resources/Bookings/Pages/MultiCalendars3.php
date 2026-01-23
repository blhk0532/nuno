<?php

namespace App\Filament\App\Clusters\Services\Resources\Bookings\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Actions\Action as FormAction;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use BackedEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Models\BookingCalendar as BookingCalendarModel;
use App\UserRole;
use Filament\Support\Enums\Width;
use Adultdate\FilamentBooking\Filament\Widgets\FilamentInfosWidget;
use Adultdate\FilamentBooking\Filament\Widgets\AccountWidget;
use Adultdate\FilamentBooking\Filament\Widgets\FullCalendarWidget;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiEventCalendar;
use App\Models\Action;
use UnitEnum;

class MultiCalendars3 extends BaseDashboard
{

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    //    protected static ?string $navigationLabel = 'Dash';

    protected static ?string $title = '';

    protected static string | UnitEnum | null $navigationGroup = 'Boknings Kalendrar';

    protected static string $routePath = 'service/multi-calendars-3';

    protected static ?int $navigationSort = 3;



    //  protected static ?string $slug = 'dashboard';

    protected string $view = 'filament.booking.pages.calendar-x3-booking';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }



    public static function getNavigationLabel(): string
    {
        return '' . Str::ucfirst('Multi Kalendrar') ?? 'User';
    }

   public static function getNavigationBadge(): ?string
    {
        return '🇹🇭 ' . now()->timezone('Asia/Bangkok')->format('H:i');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //          return 'x3';
    //
    //    }
    //
    //    public static function getNavigationBadgeColor(): ?string
    //    {
    //        return 'gray';
    //    }


   // public function filtersForm(Schema $schema): Schema
   // {
   //     $calendarOptions = BookingCalendarModel::pluck('name', 'id')->toArray();
   //     $calendarIds = array_keys($calendarOptions);

   //     return $schema
   //         ->components([
   //             Section::make()
   //                 ->schema([
   //                     Select::make('booking_calendars_1')
   //                         ->options($calendarOptions)
   //                         ->label('#1 ◴ Tekninker')
   //                         ->placeholder('Select Tekniker for Calendar 1')
   //                         ->searchable()
   //                         ->live()
   //                         ->columnSpan(3)
   //                         ->default($calendarIds[0] ?? null)
   //                         ->afterStateUpdated(function ($state) {
   //                             $this->dispatch('refreshCalendar');
   //                         }),
   //                     FormAction::make('go_to_booking')
   //                         ->label('Kalender')
   //                         ->extraAttributes([
   //                             'class' => 'go-to-booking-button',
   //                         ])
   //                         ->url('http://localhost:8000/nds/booking/service/booking?filters[booking_calendars]=1')
   //                         ->icon('heroicon-m-calendar-days')
   //                         ->color('primary'),
   //                     Select::make('booking_calendars_2')
   //                         ->options($calendarOptions)
   //                         ->label('#2 ◴ Tekninker')
   //                         ->placeholder('Select Tekniker for Calendar 2')
   //                         ->searchable()
   //                         ->live()
   //                         ->columnSpan(3)
   //                         ->default($calendarIds[1] ?? null)
   //                         ->afterStateUpdated(function ($state) {
   //                             $this->dispatch('refreshCalendar');
   //                         }),
   //                     FormAction::make('go_to_booking')
   //                         ->label('Kalender')
   //                         ->extraAttributes([
   //                             'class' => 'go-to-booking-button',
   //                         ])
   //                         ->url('http://localhost:8000/nds/booking/service/booking?filters[booking_calendars]=2')
   //                         ->icon('heroicon-m-calendar-days')
   //                         ->color('primary'),
   //                     Select::make('booking_calendars_3')
   //                         ->options($calendarOptions)
   //                         ->label('#3 ◴ Tekniker')
   //                         ->placeholder('Select Tekniker for Calendar 3')
   //                         ->searchable()
   //                         ->live()
   //                         ->columnSpan(3)
   //                         ->default($calendarIds[2] ?? null)
   //                         ->afterStateUpdated(function ($state) {
   //                             $this->dispatch('refreshCalendar');
   //                         }),
   //                     FormAction::make('go_to_booking')
   //                         ->label('Kalender')
   //                         ->extraAttributes([
   //                             'class' => 'go-to-booking-button',
   //                         ])
   //                         ->url('http://localhost:8000/nds/booking/service/booking?filters[booking_calendars]=2')
   //                         ->icon('heroicon-m-calendar-days')
   //                         ->color('primary')
   //                 ])
   //                 ->columns(12)
   //                 ->columnSpanFull(),
   //         ]);
   // }

    public function getPermissionCheckClosure(): \Closure
    {
        return fn(string $widgetClass) => true;
    }


    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function getWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getColumns(): int | array
    {
        return [
        'default' => 1, // optional base
        'sm'  => 1,
        'md'  => 1,
        'lg'  => 1,
        'xl'  => 3,
        '2xl' => 3,
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
