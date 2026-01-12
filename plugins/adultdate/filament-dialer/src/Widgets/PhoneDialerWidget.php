<?php

declare(strict_types=1);

namespace AdultDate\FilamentDialer\Widgets;

use Illuminate\Contracts\View\View;
use Filament\Widgets\Widget;

class PhoneDialerWidget extends Widget
{
    public function render(): View
    {
        return view('filament-dialer::widgets.phone-dialer');
    }

    public function getColumnSpan(): int | array | string
    {
        return 'full';
    }
}
