<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveAllPermissionsFromUser extends Command
{
    protected $signature = 'permissions:remove-all {email=super_admin@ndsth.com}';

    protected $description = 'Remove all direct permissions and roles from a user (default: super_admin@ndsth.com)';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("User with email '{$email}' not found.");

            return self::FAILURE;
        }
        $user->syncPermissions([]);
        $user->syncRoles([]);
        $this->info("Removed all permissions and roles from user: {$email}");

        return self::SUCCESS;
    }
}
