<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class CustomDashboard extends BaseDashboard
{
    // Deprecated shim kept for backward compatibility. Points to the new
    // AdminDashboard and avoids registering navigation or spotlight entries.

    protected static string $routePath = '/custom-dashboard-deprecated';

    protected static ?string $navigationLabel = 'Custom Dashboard (deprecated)';

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $isDiscovered = false;

    public static function shouldRegisterSpotlight(): bool
    {
        return false;
    }

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null): string
    {
        return AdminDashboard::getUrl($parameters, $isAbsolute, $panel, $tenant);
    }
}
