<?php

declare(strict_types=1);

namespace Guava\Calendar\Concerns;

trait HasTheme
{
    public function getTheme(): ?array
    {
        return [];
    }
}
