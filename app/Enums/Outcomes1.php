<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Outcomes1: string implements HasColor, HasIcon, HasLabel
{


    case DMC = 'Stärra';
    case Felnummer = 'Fel Telefonnummer';
    case Klickad   = 'Klickad';
    case EjIntresserad = 'Ej Intresserad';


    public function getLabel(): string
    {
        return $this->value;
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DMC => 'danger',
            self::Klickad => 'danger',
            self::EjIntresserad => 'danger',
            self::Felnummer => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::DMC => 'heroicon-m-hand-raised',
            self::Klickad => 'heroicon-m-x-circle',
            self::EjIntresserad => 'heroicon-m-hand-raised',
            self::Felnummer => 'heroicon-m-x-circle',
        };
    }

        public function getGroup(): string
    {
        return match ($this) {

        };
    }
}
