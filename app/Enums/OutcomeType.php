<?php

declare(strict_types=1);

namespace App\Enums;

enum OutcomeType: string
{
    case Block = 'Block';
    case Delete = 'Delete';
    case No = 'No';
    case Retry = 'Retry';
    case Later = 'Later';
    case Return = 'Return';
    case Maybe = 'Maybe';
    case Yes = 'Yes';
}
