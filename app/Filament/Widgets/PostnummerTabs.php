<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs;
use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class PostnummerTabs extends BaseWidget
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
                    'Postnummer Management Dashboard - Manage Swedish postal codes efficiently.',
                ]),

            TabLayoutTab::make('Statistics')
                ->icon('heroicon-o-chart-bar')
                ->badge('New')
                ->schema([
                    'View statistics and analytics for postnummer data.',
                ]),

            TabLayoutTab::make('Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    'Configure postnummer plugin settings.',
                ]),
        ];
    }
}
