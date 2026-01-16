<?php

namespace Adultdate\FilamentBooking\Enums;

use Filament\Support\Colors\Color;
use Filament\Tables\Columns\Enums\BadgeColor;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class BookingState extends State
{

    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Paid::class)
            ->allowTransition(Pending::class, Failed::class)
        ;
    }
}

class Pending extends BookingState
{
    public function color(): string
    {
        return 'warning';
    }
}

class Paid extends BookingState
{
    public function color(): string
    {
        return 'success';
    }
}

class Failed extends BookingState
{
    public function color(): string
    {
        return 'danger';
    }
}
