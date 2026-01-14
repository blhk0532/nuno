<?php

namespace App\Filament\Stats\Pages;

use Filament\Pages\Page;
use BackedEnum;

class UmamiAnalytics extends Page
{
    protected string $view = 'filament.stats.pages.umami-analytics';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Umami Analytics';

    protected static ?string $title = '';

    protected static ?string $slug = 'umami-analytics';
}
