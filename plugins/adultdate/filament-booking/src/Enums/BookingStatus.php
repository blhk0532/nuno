<?php

declare(strict_types=1);

namespace Adultdate\FilamentBooking\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BookingStatus: string implements HasLabel, HasColor, HasIcon
{
    case Booked = 'booked';
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Updated = 'updated';
    case Cancelled = 'cancelled';
    case Problem = 'problem';
    case Complete = 'complete';

    public static function toOptions(): array
    {
        return array_map(fn (self $s) => $s->getLabel(), self::cases());
    }

    public function getLabel(): ?string
    {
        return match ($this) {

            self::Booked => 'Booked',
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Updated => 'Updated',
            self::Cancelled => 'Cancelled',
            self::Problem => 'Problem',
            self::Complete => 'Complete',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Booked => 'primary',
            self::Pending => 'gray',
            self::Confirmed => 'warning',
            self::Updated => 'info',
            self::Cancelled => 'danger',
            self::Problem => 'danger',
            self::Complete => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Booked => 'heroicon-o-calendar',
            self::Pending => 'heroicon-o-clock',
            self::Confirmed => 'heroicon-o-check-circle',
            self::Updated => 'heroicon-o-pencil-square',
            self::Cancelled => 'heroicon-o-x-circle',
            self::Problem => 'heroicon-o-exclamation-triangle',
            self::Complete => 'heroicon-o-check-badge',
        };
    }

    public function getCalendarColor(): string
    {
        return match ($this) {
            self::Booked => '#3b82f6',    // Blue
            self::Pending => '#94a3b8',   // Slate
            self::Confirmed => '#f59e0b', // Amber/Yellow
            self::Updated => '#0ea5e9',   // Sky
            self::Cancelled => '#ef4444', // Red
            self::Problem => '#b91c1c',   // Dark Red
            self::Complete => '#22c55e',  // Green
        };
    }
}
