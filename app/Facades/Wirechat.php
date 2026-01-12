<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Wirechat Facade
 *
 * Note: If you see "Cannot redeclare class" error, the plugin is installed
 * in multiple locations. See README.md troubleshooting section for solutions.
 */
final class Wirechat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'wirechat'; // This will refer to the binding in the service container.
    }
}
