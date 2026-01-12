<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PhoneDialerWidget extends Widget
{
    protected string $view = 'filament.widgets.phone-dialer-widget';

    // Use a medium column span by default, adjust in dashboard placement as needed
    protected int|string|array $columnSpan = 'md';

    protected ?string $heading = 'Phone Dialer';
}
