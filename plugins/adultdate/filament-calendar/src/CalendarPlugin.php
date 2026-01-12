<?php

declare(strict_types=1);

namespace Guava\Calendar;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class CalendarPlugin implements Plugin
{
    public static function make(): static
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'guava-calendar';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
