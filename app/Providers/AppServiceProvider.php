<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\App\Widgets\TeamMembersWidget;
use App\Http\Responses\CustomLoginResponse;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Forms\Components\Toggle;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\LoginResponse;
use Livewire\Livewire;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
    }

    public function boot(): void
    {
        // Configure Livewire routes to work properly across all contexts
        // Use the $handle callback provided by Livewire instead of trying to instantiate it
        Livewire::setUpdateRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)
                ->name('livewire.update')
                ->middleware('web')
                ->withoutMiddleware(\Illuminate\Csrf\VerifyCsrfToken::class);
        });

        Livewire::setScriptRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::get('/livewire/livewire.min.js', $handle)
                ->name('livewire.script')
                ->middleware('web');
        });

        Livewire::component('app.filament.app.widgets.team-members-widget', TeamMembersWidget::class);
        Livewire::component('team-members-widget', TeamMembersWidget::class);

        // Backwards-compatibility: provide a `size()` macro for Filament Toggle
        // Some templates/plugins call `->size(...)` which isn't available in this
        // Filament version. Register a small macro that maps common sizes to CSS classes.
        Toggle::macro('size', function (string $size) {
            $classes = match ($size) {
                'sm' => 'filament-toggle-sm',
                'md' => 'filament-toggle-md',
                'lg' => 'filament-toggle-lg',
                default => $size,
            };

            // Append the class on the component; keep chainability. Merge into
            // existing extra attributes so we don't overwrite required classes.
            $this->extraAttributes(['class' => $classes], true);

            return $this;
        });

        $this->app->bind(\Filament\Auth\Http\Responses\Contracts\LoginResponse::class, function () {
            return new class implements \Filament\Auth\Http\Responses\Contracts\LoginResponse
            {
                public function toResponse($request)
                {
                    return redirect()->to('/nds/app');
                }
            };
        });

        $this->bootModelsDefaults();
        $this->bootPasswordDefaults();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        PanelSwitch::configureUsing(function (PanelSwitch $switch): void {
            $switch
                ->labels([
                    'admin' => 'Admin',
                    'app' => 'App',
                    'booking' => 'Booking',
                    'calendar' => 'Calendar',
                    'chat' => 'Chat',
                    'clients' => 'Clients',
                    'content' => 'Content',
                    'data' => 'Data',
                    'dev' => 'Dev',
                    'dialer' => 'Dialer',
                    'email' => 'Email',
                    'files' => 'Files',
                    'finance' => 'Finance',
                    'locale' => 'Locale',
                    'manager' => 'Manager',
                    'notify' => 'Notify',
                    'oauth' => 'OAuth',
                    'partner' => 'Partner',
                    'plugins' => 'Plugins',
                    'private' => 'Private',
                    'product' => 'Product',
                    'queue' => 'Queue',
                    'script' => 'Script',
                    'server' => 'Server',
                    'service' => 'Service',
                    'sheets' => 'Sheets',
                    'stats' => 'Stats',
                    'storage' => 'Storage',
                    'super' => 'Super',
                    'system' => 'System',
                    'tools' => 'Tools',
                    'user' => 'User',
                ])
                ->icons([
                    'admin' => 'heroicon-o-shield-check',
                    'app' => 'heroicon-o-user-circle',
                    'booking' => 'heroicon-o-clipboard-document-check',
                    'calendar' => 'heroicon-o-calendar-days',
                    'chat' => 'heroicon-o-chat-bubble-left-right',
                    'clients' => 'heroicon-o-user-plus',
                    'content' => 'heroicon-s-pencil-square',
                    'data' => 'heroicon-o-list-bullet',
                    'dev' => 'heroicon-m-beaker',
                    'dialer' => 'heroicon-o-phone-arrow-up-right',
                    'email' => 'heroicon-m-at-symbol',
                    'files' => 'heroicon-m-server-stack',
                    'finance' => 'heroicon-c-currency-dollar',
                    'locale' => 'heroicon-m-globe-alt',
                    'manager' => 'heroicon-m-users',
                    'notify' => 'heroicon-m-megaphone',
                    'oauth' => 'heroicon-m-lock-open',
                    'partner' => 'heroicon-c-chart-pie',
                    'plugins' => 'heroicon-m-puzzle-piece',
                    'private' => 'heroicon-m-lock-closed',
                    'product' => 'heroicon-m-shopping-bag',
                    'queue' => 'heroicon-c-queue-list',
                    'script' => 'heroicon-c-command-line',
                    'server' => 'heroicon-s-square-3-stack-3d',
                    'service' => 'heroicon-c-wrench-screwdriver',
                    'sheets' => 'heroicon-s-swatch',
                    'stats' => 'heroicon-c-chart-bar',
                    'storage' => 'heroicon-c-server',
                    'super' => 'heroicon-m-fire',
                    'system' => 'heroicon-s-circle-stack',
                    'tools' => 'heroicon-s-bolt',
                    'user' => 'heroicon-s-user-group',
                ])
                ->iconSize(20)
                ->renderHook(PanelsRenderHook::TOPBAR_LOGO_AFTER)
                ->sort('asc');

            $user = Auth::user();
            $admin = Auth::guard('admin')->user();

            $panels = [];

            if ($user?->role && $user?->role === 'guest') {
                $panels = ['guest'];
            } elseif ($user?->role && $user?->role === 'partner') {
                $panels = ['partner'];
            } elseif ($user?->role && $user?->role === 'service') {
                $panels = ['service'];
            } elseif ($user?->role && $user?->role === 'user') {
                $panels = [
                    'app',
                    'dialer',
                    'chat',
                    'email'];
            } elseif ($user?->role && $user?->role === 'booking') {
                $panels = [
                    'app',
                    'booking',
                    'calendar',
                    'chat',
                    'clients',
                    'data',
                    'dialer',
                    'email'];
            } elseif ($user?->role && $user?->role === 'manager') {
                $panels = ['app', 'booking', 'manager', 'dialer', 'stats', 'email', 'queue', 'chat'];
            } elseif ($user?->role && $user?->role === 'admin') {
                $panels = [
                    'admin',
                    'app',
                    'booking',
                    'calendar',
                    'chat',
                    'clients',
                    'content',
                    'data',
                    'dev',
                    'dialer',
                    'email',
                    'files',
                    'finance',
                    'locale',
                    'manager',
                    'notify',
                    'oauth',
                    'partner',
                    'private',
                    'product',
                    'plugins',
                    'queue',
                    'script',
                    'server',
                    'service',
                    'sheets',
                    'stats',
                    'storage',
                    'super',
                    'system',
                    'tools',
                    'user',
                ];
            } elseif ($admin?->role && $admin?->role === 'super') {
                $panels = [
                    'admin',
                    'app',
                    'booking',
                    'calendar',
                    'chat',
                    'clients',
                    'content',
                    'data',
                    'dev',
                    'dialer',
                    'email',
                    'files',
                    'finance',
                    'locale',
                    'manager',
                    'notify',
                    'oauth',
                    'partner',
                    'private',
                    'product',
                    'plugins',
                    'queue',
                    'script',
                    'server',
                    'service',
                    'sheets',
                    'stats',
                    'storage',
                    'super',
                    'system',
                    'tools',
                    'user',
                ];
            } else {
                $panels = [];
            }

            $switch->panels($panels);

        });

    }

    private function bootModelsDefaults(): void
    {
        Model::unguard();
    }

    private function bootPasswordDefaults(): void
    {
        Password::defaults(fn () => app()->isLocal() || app()->runningUnitTests() ? Password::min(12)->max(255) : Password::min(12)->max(255)->uncompromised());
    }
}
