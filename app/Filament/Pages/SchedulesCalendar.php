<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SchedulesCalendarWidget;
use BackedEnum;
use Filament\Pages\Page as BasePage;
use UnitEnum;

class SchedulesCalendar extends BasePage
{
    protected string $view = 'filament.pages.schedules-calendar';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static string|UnitEnum|null $navigationGroup = 'Schedules';

    /**
     * Return header widgets for the page so Filament will render them
     * in the page header area (the framework filters by canView()).
     *
     * @return array<class-string<\Filament\Widgets\Widget>>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            SchedulesCalendarWidget::class,
        ];
    }
}
