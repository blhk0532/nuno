<?php

namespace AdultDate\FilamentWirechat\Filament\Pages;

use AdultDate\FilamentWirechat\Filament\Widgets\WirechatWidget;
use App\Models\User as Model;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class ChatDashboard extends Page
{
    protected static ?string $slug = 'wirechat';

    protected string $view = 'filament-wirechat::filament.pages.chat-dashboard';

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'Chats';

    protected static ?int $navigationSort = 3;

    protected static ?int $sort = 3;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static bool $shouldRegisterNavigation = true;

    protected function getHeaderWidgets(): array
    {
        return [
            WirechatWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    /**
     * Get the navigation badge for unread messages count.
     * Returns null when count is 0 so badge doesn't display.
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        $unreadCount = $user->getUnreadCount() ?? 0;

        // Return null if count is 0 so badge doesn't display
        if ($unreadCount === 0) {
            return 0;
        }

        // Return formatted count (cap at 99+)
        return $unreadCount > 99 ? '99+' : (string) $unreadCount;
    }

    /**
     * Get the navigation badge color.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        $unreadCount = $user->getUnreadCount() ?? 0;

        // Only return color if there are unread messages
        return $unreadCount > 0 ? 'success' : 'gray';
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return ChatDashboard::getUrl();
    }
}
