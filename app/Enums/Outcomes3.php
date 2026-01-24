<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Outcomes3: string implements HasColor, HasIcon, HasLabel
{


    case RingIgen3 = 'Ring 3mån';
    case RingIgen6 = 'Ring 6mån';
    case RingIgen12 = 'Ring 1år';
    case RingIgen24 = 'Ring 2år';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getColor(): string
    {
        return match ($this) {

            self::RingIgen3 => 'warning',
            self::RingIgen6 => 'warning',
            self::RingIgen12 => 'warning',
            self::RingIgen24 => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {

            self::RingIgen3 => 'heroicon-m-clock',
            self::RingIgen6 => 'heroicon-m-clock',
            self::RingIgen12 => 'heroicon-m-clock',
            self::RingIgen24 => 'heroicon-m-clock',

        };
    }

        public function getGroup(): string
    {
        return match ($this) {

        };
    }
}
