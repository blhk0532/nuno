<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs;
use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class MyCalendarWidget extends BaseWidget
{
    public static function tabs(Tabs $tabs): Tabs
    {
        return $tabs
            ->contained(true);
    }

    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Overview')
                ->icon('heroicon-o-home')
                ->schema([
                    'Telephone',
                ]),

            TabLayoutTab::make('Statistics')
                ->icon('heroicon-o-chart-bar')
                ->badge('New')
                ->schema([
                    'Statistics',
                ]),

            TabLayoutTab::make('Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    'History',
                ]),
        ];
    }
}
