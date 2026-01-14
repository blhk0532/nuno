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
                    'manager' => 'Manager',
                    'queue' => 'Queue',
                    'dialer' => 'Dialer',
                    'clients' => 'Clients',
                    'finance' => 'Finance',
                    'server' => 'Server',
                    'data' => 'Data',
                    'super' => 'Super',
                    'dev' => 'Dev',
                    'partner' => 'Partner',
                    'service' => 'Service',
                    'tools' => 'Tools',
                    'files' => 'Files',
                    'system' => 'System',
                    'chat' => 'Chat',
                    'stats' => 'Stats',
                    'calendar' => 'Calendar',
                    'sheets' => 'Sheets',
                    'email' => 'Email',
                    'notify' => 'Notify',
                    'user' => 'User',
                    'script' => 'Script',
                    'guest' => 'Guest',
                    'private' => 'Private',
                    'storage' => 'Storage',
                ])
                ->icons([
                    'admin' => 'heroicon-o-shield-check',
                    'app' => 'heroicon-s-squares-plus',
                    'booking' => 'heroicon-c-clipboard-document-check',
                    'manager' => 'heroicon-m-users',
                    'queue' => 'heroicon-c-queue-list',
                    'dialer' => 'heroicon-c-megaphone',
                    'clients' => 'heroicon-c-user-plus',
                    'finance' => 'heroicon-c-currency-dollar',
                    'server' => 'heroicon-s-square-3-stack-3d',
                    'data' => 'heroicon-s-cloud-arrow-down',
                    'super' => 'heroicon-m-fire',
                    'dev' => 'heroicon-m-beaker',
                    'partner' => 'heroicon-c-chart-pie',
                    'service' => 'heroicon-c-wrench-screwdriver',
                    'tools' => 'heroicon-s-bolt',
                    'files' => 'heroicon-m-server-stack',
                    'system' => 'heroicon-s-circle-stack',
                    'chat' => 'heroicon-m-chat-bubble-bottom-center-text',
                    'stats' => 'heroicon-c-chart-bar',
                    'calendar' => 'heroicon-o-calendar-days',
                    'sheets' => 'heroicon-s-swatch',
                    'email' => 'heroicon-c-at-symbol',
                    'notify' => 'heroicon-s-bell-snooze',
                    'user' => 'heroicon-s-user-group',
                    'script' => 'heroicon-c-command-line',
                    'guest' => 'heroicon-c-user-circle',
                    'private' => 'heroicon-m-server-stack',
                    'storage' => 'heroicon-c-server',
                ])
                ->iconSize(20)
                ->renderHook('panels::global-search.after');
            //  ->sort('asc');

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
                $panels = ['admin', 'app', 'booking', 'manager', 'queue', 'dialer', 'clients', 'finance', 'guest', 'script', 'user',
                           'server', 'partner', 'service', 'tools', 'files', 'chat', 'stats', 'calendar', 'sheets', 'email', 'notify'];
            }elseif ($admin?->role && $admin?->role === 'super') {
                $panels = [
                'admin',
                'app',
                'booking',
                'calendar',
                'chat',
                'clients',
                'data',
                'dev',
                'dialer',
                'email',
                'files',
                'finance',
                'guest',
                'manager',
                'notify',
                'partner',
                'private',
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
