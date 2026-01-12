<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Panel;

class DialPad extends BaseDashboard
{
    protected static bool $isDiscovered = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Dial Pad';

    protected static ?int $navigationSort = 100;

    public function getColumns(): int
    {
        return 2;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderTitle(): string|false
    {
        return false;
    }

    public static function getRoutePath(Panel $panel): string
    {
        return '/dial-pad';
    }

    public static function getRelativeRouteName(Panel $panel): string
    {
        return 'dial-pad';
    }
}
