<?php

namespace App\Filament\Admin\Pages;

use Shreejan\DashArrange\Traits\HasDashArrange;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Layouts\Layout;
use App\Filament\Admin\Widgets\AccountWidget;
use App\Filament\Admin\Widgets\FilamentInfoWidget;
use Filament\Widgets\Widget;
use App\Filament\Admin\Widgets\UserDonut;
use App\Filament\Admin\Widgets\AccountInfoStackWidget;
use App\Filament\Admin\Widgets\WorldClockWidget;

class Dashboard extends BaseDashboard
{
    use HasDashArrange;

    protected string $view = 'dash-arrange::dashboard';

    public function mount(): void
    {
        // Initialize DashArrange functionality
        $this->mountHasDashArrange();
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public static function getNavigationLabel(): string
    {
        return 'Administration';
    }

    public static function getNavigationBadge(): ?string
    {
        return now()->timezone('Asia/Bangkok')->format('H:i');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'white';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shield-check';
    }


    public function getHeaderWidgets(): array
    {

        return [
            AccountInfoStackWidget::class,
            WorldClockWidget::class,
        ];
    }
}
