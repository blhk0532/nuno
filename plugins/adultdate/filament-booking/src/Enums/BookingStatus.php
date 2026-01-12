<?php

namespace Adultdate\FilamentBooking\Enums;

use Filament\Support\Colors\Color;
use Filament\Tables\Columns\Enums\BadgeColor;

enum BookingStatus: string
{

    case Booked = 'booked';
    case Confirmed = 'confirmed';
    case Updated = 'updated';
    case Cancelled = 'cancelled';
    case Problem = 'problem';
    case Complete = 'complete';

    public function getLabel(): string
    {
        return match ($this) {

            self::Booked => 'Booked',
            self::Confirmed => 'Confirmed',
            self::Updated => 'Updated',
            self::Cancelled => 'Cancelled',
            self::Problem => 'Problem',
            self::Complete => 'Complete',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Booked => 'primary',
            self::Confirmed => 'warning',
            self::Updated => 'info',
            self::Cancelled => 'danger',
            self::Problem => 'danger',
            self::Complete => 'success',
        };
    }

    public static function toOptions(): array
    {
        return array_map(fn (self $s) => $s->getLabel(), self::cases());
    }
}
