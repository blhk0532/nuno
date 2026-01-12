<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SampleBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 15 sample bookings. Assign some to the first real user if present.
        $user = User::first();

        \Database\Factories\Booking\BookingFactory::new()
            ->count(10)
            ->sequence(fn ($seq) => [
                'booking_user_id' => $user?->id,
                'service_user_id' => $user?->id,
            ])
            ->create();

        // Create a few bookings for other random users
        \Database\Factories\Booking\BookingFactory::new()->count(5)->create();
    }
}
