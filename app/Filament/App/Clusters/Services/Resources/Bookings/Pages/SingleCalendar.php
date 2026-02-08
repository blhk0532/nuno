<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Bookings\Pages;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\SingleCalendars;
use App\Models\BookingCalendar as BookingCalendarModel;
use BackedEnum;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;

final class SingleCalendar extends BaseDashboard
{
    public ?string $calendarId = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    //     protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-calendar-days';
    protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarCheckLine;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarCheckFill;

    protected static ?string $navigationLabel = 'Kalender';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 6;

    protected static ?int $sort = 6;

    protected static string $routePath = 'single-calendar';

    protected static string|UnitEnum|null $navigationGroup = ' ';

    //   use HasFiltersForm;
    //  protected static ?string $slug = 'dashboard';

    protected string $view = 'filament-booking::pages.page';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    //    public static function getNavigationLabel(): string
    //    {
    //        return '' . Str::ucfirst('Kalendrar') ?? 'NDS Kalender';
    //    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        //  return now()->format('H:m');
    //     return 'x1';
    //    }
    //
    //    public static function getNavigationBadgeColor(): ?string
    //    {
    //        return 'gray';
    //    }

    //                public static function getNavigationSort(): ?int
    //   {
    //       return 2;
    //   }
    //
    //               public static function getSort(): ?int
    //   {
    //       return 2;
    //   }

    //   public static function getNavigationBadge(): ?string
    //   {
    //       //    return '🇹🇭 ' . now()->timezone('Asia/Bangkok')->format('H:i');
    //       Carbon::setLocale('sv');
    //       return now()
    //           ->timezone('Europe/Stockholm')
    //           ->translatedFormat('d M');
    //   }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

    public function mount(): void
    {
        $calendarId = request()->query('booking_calendars') ?? BookingCalendarModel::first()?->id;
        $this->calendarId = $calendarId !== null ? (string) $calendarId : null;
        $this->startDate = request()->query('startDate') ?? now()->startOfWeek()->toDateString();
        $this->endDate = request()->query('endDate') ?? now()->endOfWeek()->toDateString();
        logger()->info('SingleCalendar mount', ['full_url' => request()->fullUrl(), 'query' => request()->query(), 'calendarId' => $this->calendarId]);
    }

    public function getWidgets(): array
    {
        return [
            SingleCalendars::class,
        ];
    }

    public function getWidgetData(): array
    {
        return [
            'calendar_id' => $this->calendarId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    //    public function filtersForm(Schema $schema): Schema
    //    {
    //        return $schema
    //            ->components([
    //                Section::make()
    //                    ->schema([
    //                        Select::make('booking_calendars')
    //                            ->options(fn () => ['all' => 'Show All'] + BookingCalendarModel::pluck('name', 'id')->toArray())
    //                            ->label('Tekninker')
    //                            ->placeholder('Select a calendar owner')
    //                            ->searchable()
    //                            ->default('all')
    //                            ->reactive()
    //                            ->afterStateUpdated(function () {
    //                                $this->dispatch('refreshCalendar');
    //                            }),
    //
    //
    //                        DatePicker::make('startDate')
    //                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
    //                        DatePicker::make('endDate')
    //                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
    //                            ->maxDate(now()),
    //                    ])
    //                    ->columns(3)
    //                    ->columnSpanFull(),
    //            ]);
    //    }

    public function getPermissionCheckClosure(): Closure
    {
        return fn (string $widgetClass) => true;
    }
}
