<?php

declare(strict_types=1);

namespace Guava\Calendar\Attributes;

use Attribute;
use Illuminate\Database\Eloquent\Model;

#[Attribute(Attribute::TARGET_METHOD)]
final class CalendarEventContent
{
    /**
     * @param  class-string<Model>  $model
     */
    public function __construct(public string $model) {}
}
