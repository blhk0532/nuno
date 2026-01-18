<?php

namespace App\Filament\Clients\Clusters\Services\Resources\Bookings\Pages;

// use Adultdate\FilamentBooking\Filament\Widgets\BookingCalendarWidget;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\Page as BasePage;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use UnitEnum;
use App\Filament\Clients\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar;
use App\Models\BookingCalendar as BookingCalendarModel;
use App\UserRole;

class PageBooking extends BasePage
{
    use HasFiltersForm;

    protected string $view = 'filament-booking::pages.page';

    protected static ?string $navigationLabel = 'Booking';

     // protected static string $routePath = 'services';
    protected static ?string $slug = '';

    protected static string $routePath = 'page/booking';

    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $sort = 1;

    protected static string | UnitEnum | null $navigationGroup = '';

        protected static bool $shouldRegisterNavigation = false;

 protected static bool $isDiscovered = false;

    public static function shouldRegisterSpotlight(): bool
    {
        return false;
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_calendars')
                    ->label('Calendars')
                    ->options(fn () => ['all' => 'Show All'] + BookingCalendarModel::whereHas('owner', fn($q) => $q->where('role', UserRole::SERVICE))->pluck('name', 'id')->toArray())
                    ->placeholder('Select a calendar')
                    ->default('all')
                    ->reactive()
                    ->afterStateUpdated(function () {
                        $this->dispatch('refreshCalendar');
                    }),
            ]);
    }

    /**
     * Return header widgets for the page.
     *
     * @return array<class-string<Widget>>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            BookingCalendar::class,
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make('create-new-booking')::make()
                ->label('New schedule')
                ->icon('heroicon-o-calendar'),];
    }
}
