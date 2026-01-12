<?php

declare(strict_types=1);

namespace Guava\Calendar\Concerns;

use Guava\Calendar\ValueObjects\ViewDidMountInfo;

trait HandlesViewDidMount
{
    protected bool $viewDidMountEnabled = false;

    public function isViewDidMountEnabled(): bool
    {
        return $this->viewDidMountEnabled;
    }

    /**
     * @internal Do not override, internal purpose only. Use `onViewDidMount` instead
     */
    public function onViewDidMountJs(array $data): void
    {
        // Check if viewDidMount is enabled
        if (! $this->isViewDidMountEnabled()) {
            return;
        }

        $this->onViewDidMount(new ViewDidMountInfo($data, $this->shouldUseFilamentTimezone()));
    }

    protected function onViewDidMount(ViewDidMountInfo $info): void {}
}
