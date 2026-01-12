<?php

namespace App\Policies;

use Adultdate\FilamentBooking\Models\Booking\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, Booking $booking): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, Booking $booking): bool
    {
        return true;
    }

    public function delete(mixed $user, Booking $booking): bool
    {
        return true;
    }

    public function restore(mixed $user, Booking $booking): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, Booking $booking): bool
    {
        return true;
    }
}
