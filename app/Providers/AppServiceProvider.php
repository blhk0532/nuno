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
                    'client' => 'Client',
                    'finance' => 'Finance',
                    'server' => 'Server',
                    'data' => 'Data',
                    'super' => 'Super',
                    'dev' => 'Dev',
                    'partner' => 'Partner',
                    'service' => 'Service',
                    'tools' => 'Tools',
                    'storage' => 'Storage',
                    'system' => 'System',
                    'chat' => 'Chat',
                    'stats' => 'Stats',
                    'calendar' => 'Calendar',
                    'sheets' => 'Sheets',
                    'email' => 'Email',
                    'notify' => 'Notify',
                    'user' => 'User',
                ])
                ->icons([
                    'admin' => 'heroicon-o-shield-check',
                    'app' => 'heroicon-o-fire',
                    'booking' => 'heroicon-o-check-circle',
                    'manager' => 'heroicon-o-users',
                    'queue' => 'heroicon-o-list-bullet',
                    'dialer' => 'heroicon-o-phone',
                    'clients' => 'heroicon-o-user-group',
                    'finance' => 'heroicon-o-currency-dollar',
                    'server' => 'heroicon-o-server',
                    'data' => 'heroicon-o-server-stack',
                    'super' => 'heroicon-o-star',
                    'dev' => 'heroicon-o-cog-6-tooth',
                    'partner' => 'heroicon-o-user-plus',
                    'service' => 'heroicon-o-lifebuoy',
                    'tools' => 'heroicon-o-wrench',
                    'storage' => 'heroicon-o-folder',
                    'system' => 'heroicon-o-computer-desktop',
                    'chat' => 'heroicon-o-chat-bubble-left-right',
                    'stats' => 'heroicon-o-chart-bar',
                    'calendar' => 'heroicon-o-calendar-days',
                    'sheets' => 'heroicon-o-document-text',
                    'email' => 'heroicon-o-envelope',
                    'notify' => 'heroicon-o-bell',
                    'user' => 'heroicon-o-user-circle',
                ])
                ->iconSize(20)
                ->renderHook('panels::global-search.after');
            //  ->sort('asc');

            $user = Auth::user();
            $admin = Auth::guard('admin')->user();

            $panels = [];

            if ($user instanceof User && $user->hasRole('super_admin') || $user instanceof User && $user->hasRole('superadmin') || $user instanceof User && $user->hasRole('super')) {
                $panels = ['admin', 'app', 'booking', 'manager', 'queue', 'dialer', 'clients', 'finance', 'server', 'data', 'super', 'dev',
                    'partner', 'service', 'tools', 'storage', 'system', 'chat', 'stats', 'calendar', 'sheets', 'email', 'notify', 'user'];
            } elseif (
                ($admin instanceof Admin && ($admin->role === 'admin')) ||
                ($user instanceof User && $user->hasRole('admin'))
            ) {
                $panels = ['admin', 'app', 'booking', 'manager', 'queue', 'dialer', 'clients', 'finance',
                    'server', 'partner', 'service', 'tools', 'storage', 'chat', 'stats', 'calendar', 'sheets', 'email', 'notify', 'user'];
            } elseif ($user instanceof User && (! $user->hasRole('super_admin') && ! $user->hasRole('admin'))) {
                $panels = [];
            }

            if (($user instanceof User && $user->hasRole('manager')) || ($admin instanceof Admin && $admin->role === 'manager')) {
                $panels = ['app', 'booking', 'manager', 'dialer', 'stats', 'email', 'queue', 'chat'];
            }

            if ($admin instanceof Admin && ($admin->role === 'super_admin' || $admin->role === 'superadmin' || $admin->role === 'super')) {
                $panels = ['admin', 'app', 'booking', 'manager', 'queue', 'dialer', 'clients', 'finance', 'server', 'data', 'super', 'dev',
                    'partner', 'service', 'tools', 'storage', 'system', 'chat', 'stats', 'calendar', 'sheets', 'email', 'notify', 'user'];
            }

            if ($user instanceof User && ($user->hasRole('super_admin') || $user->hasRole('superadmin') || $user->hasRole('super'))) {
                $panels = ['admin', 'app', 'booking', 'manager', 'queue', 'dialer', 'clients', 'finance', 'server', 'data', 'super', 'dev',
                    'partner', 'service', 'tools', 'storage', 'system', 'chat', 'stats', 'calendar', 'sheets', 'email', 'notify', 'user'];
            }

            if ($user instanceof User && ($user->hasRole('admin') || $user->hasRole('administrator'))) {
                $panels = ['admin', 'calendar', 'booking', 'clients', 'app', 'manager', 'queue', 'dialer', 'finance',
                    'server', 'partner', 'service', 'tools', 'storage', 'chat', 'stats', 'sheets', 'email', 'notify', 'user'];
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
