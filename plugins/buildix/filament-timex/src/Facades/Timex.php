<?php

declare(strict_types=1);

namespace Buildix\Timex\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Buildix\Timex\Timex
 */
final class Timex extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'timex';
    }
}
