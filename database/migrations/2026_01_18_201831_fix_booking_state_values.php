<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix invalid state values that are not registered in BookingState
        DB::table('booking_bookings')->where('state', 'booked')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Pending']);
        DB::table('booking_bookings')->where('state', 'confirmed')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Paid']);
        DB::table('booking_bookings')->where('state', 'pending')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Pending']);
        DB::table('booking_bookings')->where('state', 'cancelled')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Failed']);
        DB::table('booking_bookings')->where('state', 'problem')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Failed']);
        DB::table('booking_bookings')->where('state', 'complete')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Paid']);
        DB::table('booking_bookings')->where('state', 'updated')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Pending']);
        DB::table('booking_bookings')->where('state', 'processing')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Pending']);
        DB::table('booking_bookings')->where('state', 'new')->update(['state' => 'Adultdate\\FilamentBooking\\Enums\\Pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This is not reversible as we don't know the original values
    }
};
