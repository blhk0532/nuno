<?php

namespace Database\Seeders;

use Adultdate\FilamentAuth\Filament\Resources\Shop\Orders\OrderResource;
use Adultdate\FilamentAuth\Models\Address;
use Adultdate\FilamentAuth\Models\Blog\Author;
use Adultdate\FilamentAuth\Models\Blog\Category as BlogCategory;
use Adultdate\FilamentAuth\Models\Blog\Post;
use Adultdate\FilamentAuth\Models\Comment;
use Adultdate\FilamentAuth\Models\Shop\Brand;
use Adultdate\FilamentAuth\Models\Shop\Category as ShopCategory;
use Adultdate\FilamentAuth\Models\Shop\Customer;
use Adultdate\FilamentAuth\Models\Shop\Order;
use Adultdate\FilamentAuth\Models\Shop\OrderItem;
use Adultdate\FilamentAuth\Models\Shop\Payment;
use Adultdate\FilamentAuth\Models\Shop\Product;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Adultdate\FilamentAuth\Models\User;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::raw('SET time_zone=\'+00:00\'');

        User::firstOrCreate(
            ['email' => 'super@ndsth.com'],
            [
                'name' => 'super',
                'role' => 'super_admin',
                'password' => 'bkkbkk',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'admin@ndsth.com'],
            [
                'name' => 'admin',
                'role' => 'super_admin',
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
            ['email' => 'bokning@ndsth.com'],
            [
                'name' => 'Bokning',
                'role' => 'booking',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'agent@ndsth.com'],
            [
                'name' => 'Agent',
                'role' => 'agent',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'partner@ndsth.com'],
            [
                'name' => 'Partner',
                'role' => 'partner',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'service@ndsth.com'],
            [
                'name' => 'Service',
                'role' => 'service',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'manager@ndsth.com'],
            [
                'name' => 'Manager',
                'role' => 'manager',
                'password' => 'qwe321asd',
                'email_verified_at' => now(),
            ]
        );
        User::firstOrCreate(
            ['email' => 'supervisor@ndsth.com'],
            [
                'name' => 'Supervisor',
                'role' => 'supervisor',
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
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
