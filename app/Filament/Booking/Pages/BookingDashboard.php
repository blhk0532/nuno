<?php

namespace App\Filament\Booking\Pages;

use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Filament\Admin\Widgets\WorldClockWidget;
class BookingDashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    protected static ?string $title = '';


    protected static ?string $navigationLabel = 'Bokning NDS';


    protected static ?string $slug = 'dashboard';
    // Prevent this app-level Dashboard from being auto-discovered so that
    // the explicit `AdminDashboard` can be registered as the admin panel root.
    protected static bool $isDiscovered = true;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-pie';

    //  public function filtersForm(Schema $schema): Schema
    //  {
    //      return $schema
    //          ->components([
    //              Section::make()
    //                  ->schema([
    //                      Select::make('Business')
    //                          ->boolean(),
    //                      Select::make('Persons')
    //                          ->boolean(),
    //                      DatePicker::make('startDate')
    //                          ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
    //                      DatePicker::make('endDate')
    //                          ->minDate(fn (Get $get) => $get('startDate') ?: now())
    //                          ->maxDate(now()),
    //                  ])
    //                  ->columns(4)
    //                  ->columnSpanFull(),
    //          ]);
    //  }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return Str::ucfirst('Bokning NDS') ?? null;
    }

    public static function getNavigationBadge(): ?string
    {
        //  return now()->format('H:m');
          return now()->timezone('Europe/Stockholm')->format('H:i');

    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-c-calendar-days';
    }



    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

        public function getHeaderWidgets(): array
    {

        return [
            AccountInfoStackWidget::class,
            WorldClockWidget::class,
        ];
    }
}
