<?php

namespace App\Filament\Pages\App;

use Filament\Pages\Dashboard as BaseDashboard;

class AppDashboard extends BaseDashboard
{
    // Compatibility shim for the alternate namespace that some
    // plugins / Livewire expect. Prevent this shim from registering
    // navigation items or Spotlight entries for the admin panel.

    // Prevent this shim from being auto-discovered/registered by panels.
    protected static bool $isDiscovered = false;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function shouldRegisterSpotlight(): bool
    {
        return false;
    }

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null): string
    {
        // Ensure URLs generated for this compatibility shim always point to the `app` panel,
        // even when the current panel during boot is `admin`. This avoids route-not-found
        // errors when other plugins (e.g. Spotlight) call `::getUrl()` without a panel.
        return parent::getUrl($parameters, $isAbsolute, $panel ?? 'app', $tenant);
    }
}
