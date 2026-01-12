<?php

namespace Adultdate\FilamentAuth;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Colors;
use Filament\Support\Facades\FilamentAsset;

class FilamentAuth implements Plugin
{
    public function getId(): string
    {
        return 'filament-auth';
    }

    public function register(Panel $panel): void
    {
        FilamentAsset::register([
            Theme::make('filament-auth', __DIR__ . '/../resources/dist/filament-auth.css'),
        ]);

        $panel
            ->font('DM Sans')
            ->primaryColor(\Filament\Support\Colors\Color::Amber)
            ->secondaryColor(\Filament\Support\Colors\Color::Gray)
            ->warningColor(\Filament\Support\Colors\Color::Amber)
            ->dangerColor(\Filament\Support\Colors\Color::Rose)
            ->successColor(\Filament\Support\Colors\Color::Green)
            ->grayColor(\Filament\Support\Colors\Color::Gray)
            ->theme('filament-auth');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
