<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class GenerateManualPermissions extends Command
{
    protected $signature = 'permissions:generate-manual';

    protected $description = 'Manually create permissions for User and Team resources';

    public function handle(): int
    {
        $resources = [
            'User',
            'Team',
        ];

        $actions = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
        ];

        $count = 0;
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $name = "{$resource}:{$action}";
                $permission = Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
                if ($permission->wasRecentlyCreated) {
                    $this->info("Created permission: {$name}");
                    $count++;
                }
            }
        }
        $this->info("Total permissions created: {$count}");

        return self::SUCCESS;
    }
}
