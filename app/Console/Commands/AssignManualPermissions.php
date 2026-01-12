<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignManualPermissions extends Command
{
    protected $signature = 'permissions:assign-manual {role=super_admin}';

    protected $description = 'Assign all User and Team permissions to a role (default: super_admin)';

    public function handle(): int
    {
        $roleName = $this->argument('role');
        $role = Role::where('name', $roleName)->first();
        if (! $role) {
            $this->error("Role '{$roleName}' not found.");

            return self::FAILURE;
        }

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
        $permissions = [];
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permissions[] = "{$resource}:{$action}";
            }
        }
        $role->syncPermissions($permissions);
        $this->info("Assigned permissions to role '{$roleName}':");
        foreach ($permissions as $perm) {
            $this->line("- {$perm}");
        }

        return self::SUCCESS;
    }
}
