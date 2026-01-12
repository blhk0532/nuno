<?php

declare(strict_types=1);

namespace Guava\Calendar\Contracts;

use Guava\Calendar\Enums\Context;

interface ContextualInfo
{
    public function getContext(): Context;
}
