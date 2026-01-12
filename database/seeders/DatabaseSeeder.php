<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Super;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
             DB::raw('SET time_zone=\'Europe/Stockholm\'');

        // Super

        Super::firstOrCreate(
            ['email' => 'super@ndsth.com'],
            [
                'name' => 'super',
                'role' => 'super',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        //    Super::firstOrCreate(
        //        ['email' => 'admin@ndsth.com'],
        //        [
        //            'name' => 'admin',
        //            'role' => 'admin',
        //            'password' => 'bkkbkk',
        //            'email_verified_at' => now(),
        //        ]
        //    );

        // Admin

        Admin::firstOrCreate(
            ['email' => 'super@ndsth.com'],
            [
                'name' => 'super',
                'role' => 'super',
                'is_super_admin' => true,
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        Admin::firstOrCreate(
            ['email' => 'admin@ndsth.com'],
            [
                'name' => 'admin',
                'role' => 'admin',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        Admin::firstOrCreate(
            ['email' => 'matsod@ndsth.com'],
            [
                'name' => 'Mathias',
                'role' => 'admin',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        Admin::firstOrCreate(
            ['email' => 'daniel@ndsth.com'],
            [
                'name' => 'Daniel',
                'role' => 'admin',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );

        // Users

        User::firstOrCreate(
            ['email' => 'super@ndsth.com'],
            [
                'name' => 'super',
                'role' => 'super',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'admin@ndsth.com'],
            [
                'name' => 'admin',
                'role' => 'admin',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'matsod@ndsth.com'],
            [
                'name' => 'Mathias',
                'role' => 'admin',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'daniel@ndsth.com'],
            [
                'name' => 'Daniel',
                'role' => 'admin',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'kat@ndsth.com'],
            [
                'name' => 'Berit',
                'role' => 'manager',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'bokning1@ndsth.com'],
            [
                'name' => 'Bokning1',
                'role' => 'booking',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'bokning2@ndsth.com'],
            [
                'name' => 'Bokning2',
                'role' => 'booking',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'bokning3@ndsth.com'],
            [
                'name' => 'Bokning3',
                'role' => 'booking',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'manager1@ndsth.com'],
            [
                'name' => 'Manager1',
                'role' => 'manager',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'manager2@ndsth.com'],
            [
                'name' => 'Manager2',
                'role' => 'manager',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'guest@ndsth.com'],
            [
                'name' => 'Guest',
                'role' => 'guest',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'user1@ndsth.com'],
            [
                'name' => 'User 1',
                'role' => 'user',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'user2@ndsth.com'],
            [
                'name' => 'User 2',
                'role' => 'user',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'user3@ndsth.com'],
            [
                'name' => 'User 3',
                'role' => 'user',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'user4@ndsth.com'],
            [
                'name' => 'User 4',
                'role' => 'user',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'service1@example.com'],
            [
                'name' => 'Tekniker 1',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'service2@example.com'],
            [
                'name' => 'Tekniker 2',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'service3@example.com'],
            [
                'name' => 'Tekniker 3',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'service4@example.com'],
            [
                'name' => 'Tekniker 4',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );

        // Service

        Service::firstOrCreate(
            ['email' => 'service1@example.com'],
            [
                'name' => 'Tekniker 1',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        Service::firstOrCreate(
            ['email' => 'service2@example.com'],
            [
                'name' => 'Tekniker 2',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        Service::firstOrCreate(
            ['email' => 'service3@example.com'],
            [
                'name' => 'Tekniker 3',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        Service::firstOrCreate(
            ['email' => 'service4@example.com'],
            [
                'name' => 'Tekniker 4',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );

        // Partner

        Partner::firstOrCreate(
            ['email' => 'partner1@example.com'],
            [
                'name' => 'Partner 1',
                'role' => 'partner',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        Partner::firstOrCreate(
            ['email' => 'partner2@example.com'],
            [
                'name' => 'Partner 2',
                'role' => 'Partner',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );

        // Booking

        $this->call([
            BookingBrandSeeder::class,
            BookingCategorySeeder::class,
            BookingClientSeeder::class,
            BookingServiceSeeder::class,
        ]);
    }
}
