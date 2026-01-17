<?php

namespace App\Filament\Admin\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class AccountWidget extends Widget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected string $view = 'filament-panels::widgets.account-widget';

    public static function canView(): bool
    {
        return Filament::auth()->check();
    }

public function getColumnSpan(): int | array
{
    return [
        'default' => 'full',
        'lg' => 1,
    ];
}

}
