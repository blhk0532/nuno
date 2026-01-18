<?php

declare(strict_types=1);

namespace Adultdate\FilamentBooking\Enums;

enum BookingStatus: string
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

    public function getLabel(): string
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

    public function getColor(): string
    {
        return match ($this) {
            self::Booked => 'primary',
            self::Pending => 'secondary',
            self::Confirmed => 'warning',
            self::Updated => 'info',
            self::Cancelled => 'danger',
            self::Problem => 'danger',
            self::Complete => 'success',
        };
    }
}
