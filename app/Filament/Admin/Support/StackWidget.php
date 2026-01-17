<?php

namespace App\Filament\Admin\Support;

use Filament\Widgets\Widget;
use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Filament\Admin\Widgets\FilamentInfoWidget;

trait StackWidget

{
    /**
     * @return array<class-string<Widget>>
     */
    protected function getStackedWidgets(): array
    {
        return [
AccountInfoStackWidget::class,
FilamentInfoWidget::class,

        ];
    }

    protected function getViewData(): array
    {
        return [
            'stackedWidgets' => $this->getStackedWidgets(),
        ];
    }
}
