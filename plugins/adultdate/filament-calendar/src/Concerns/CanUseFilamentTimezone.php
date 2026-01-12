<?php

declare(strict_types=1);

namespace Guava\Calendar\Concerns;

trait CanUseFilamentTimezone
{
    protected bool $useFilamentTimezone = false;

    public function shouldUseFilamentTimezone(): bool
    {
        return $this->useFilamentTimezone;
    }
}
