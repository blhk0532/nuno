<?php

declare(strict_types=1);

namespace Guava\Calendar\Contracts;

use Guava\Calendar\ValueObjects\CalendarEvent;

interface Eventable
{
    public function toCalendarEvent(): CalendarEvent;
}
