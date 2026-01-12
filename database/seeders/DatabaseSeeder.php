<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::raw('SET time_zone=\'Europe/Stockholm\'');

        // Super

        User::firstOrCreate(
            ['email' => 'super@ndsth.com'],
            [
                'name' => 'super',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
    }
}
