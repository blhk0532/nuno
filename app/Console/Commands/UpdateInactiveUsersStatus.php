<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\UserActiveStatus;
use App\Models\User;
use Illuminate\Console\Command;

final class UpdateInactiveUsersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-inactive-status {--minutes=5 : Minutes of inactivity before setting to offline}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users who have been inactive for the specified minutes to offline status';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $minutes = (int) $this->option('minutes');

        $this->info("Updating users inactive for {$minutes} minutes to offline status...");

        $inactiveUsers = User::where('active_at', '<', now()->subMinutes($minutes))
            ->where('active_status', '!=', UserActiveStatus::Offline)
            ->update([
                'active_status' => UserActiveStatus::Offline,
            ]);

        $this->info("Updated {$inactiveUsers} users to offline status.");

        return self::SUCCESS;
    }
}
