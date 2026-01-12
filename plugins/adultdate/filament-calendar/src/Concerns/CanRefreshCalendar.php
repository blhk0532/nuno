<?php

declare(strict_types=1);

namespace Guava\Calendar\Concerns;

trait CanRefreshCalendar
{
    public function refreshRecords(): static
    {
        $this->dispatch('calendar--refresh');

        return $this;
    }

    public function refreshResources(): static
    {
        $this->setOption('resources', $this->getResourcesJs());

        return $this;
    }
}
