<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use BezhanSalleh\PanelSwitch\PanelSwitch;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
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
                    'app' => 'heroicon-s-squares-plus',
                    'booking' => 'heroicon-c-clipboard-document-check',
                    'calendar' => 'heroicon-s-calendar-days',
                    'chat' => 'heroicon-m-chat-bubble-bottom-center-text',
                    'clients' => 'heroicon-c-user-plus',
                    'content' => 'heroicon-s-pencil-square',
                    'data' => 'heroicon-s-cloud-arrow-down',
                    'dev' => 'heroicon-m-beaker',
                    'dialer' => 'heroicon-c-megaphone',
                    'email' => 'heroicon-m-at-symbol',
                    'files' => 'heroicon-m-server-stack',
                    'finance' => 'heroicon-c-currency-dollar',
                    'locale' => 'heroicon-m-globe-alt',
                    'manager' => 'heroicon-m-users',
                    'notify' => 'heroicon-s-bell-snooze',
                    'oauth' => 'heroicon-m-lock-closed',
                    'partner' => 'heroicon-c-chart-pie',
                    'plugins' => 'heroicon-m-puzzle-piece',
                    'private' => 'heroicon-m-server-stack',
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
                ->renderHook('panels::global-search.after')
                ->sort('asc');

            $user = Auth::user();
            $admin = Auth::guard('admin')->user();

            $panels = [];

            if ($user?->role && $user?->role === 'guest'){
                $panels = ['guest'];
            }elseif ($user?->role && $user?->role === 'partner'){
                $panels = ['partner'];
            }elseif ($user?->role && $user?->role === 'service'){
                $panels = ['service'];
            }elseif ($user?->role && $user?->role === 'user') {
                $panels = ['app',
                           'dialer',
                           'chat',
                           'email'];
            }elseif ($user?->role && $user?->role === 'booking'){
                $panels = ['app',
                           'dialer',
                           'chat',
                           'email'];
            }elseif ($user?->role && $user?->role === 'manager') {
                $panels = ['app', 'booking', 'manager', 'dialer', 'stats', 'email', 'queue', 'chat'];
            }elseif ($user?->role && $user?->role === 'admin') {
               $panels = [
                'admin',
                'app',
                'booking',
                'calendar',
                'chat',
                'clients',
                'data',
                'dialer',
                'email',
                'files',
                'finance',
                'locale',
                'manager',
                'notify',
                'partner',
                'product',
                'plugins',
                'queue',
                'script',
                'service',
                'sheets',
                'stats',
                'tools',
                'user',
            ];
            }elseif ($admin?->role && $admin?->role === 'super') {
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
            }else{
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
