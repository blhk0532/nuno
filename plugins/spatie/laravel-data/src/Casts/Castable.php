<?php

namespace Spatie\LaravelData\Casts;

interface Castable
{
    public static function dataCastUsing(array $arguments): Cast;
}
