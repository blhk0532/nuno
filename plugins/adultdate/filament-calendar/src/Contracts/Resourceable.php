<?php

declare(strict_types=1);

namespace Guava\Calendar\Contracts;

use Guava\Calendar\ValueObjects\CalendarResource;

interface Resourceable
{
    public function toCalendarResource(): CalendarResource;
}
