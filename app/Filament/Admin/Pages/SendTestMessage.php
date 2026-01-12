<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class SendTestMessage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = 'WhatsApp';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationLabel = 'Send Test Message';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return 'Send Test Message';
    }

    public function getViewData(): array
    {
        return [];
    }

    public function getView(): string
    {
        return 'filament.admin.pages.send-test-message';
    }
}
