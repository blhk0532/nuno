<?php

namespace App\Policies;

use App\Models\BookingServicePeriod;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingServicePeriodPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, BookingServicePeriod $bookingServicePeriod): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, BookingServicePeriod $bookingServicePeriod): bool
    {
        return true;
    }

    public function delete(mixed $user, BookingServicePeriod $bookingServicePeriod): bool
    {
        return true;
    }

    public function restore(mixed $user, BookingServicePeriod $bookingServicePeriod): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, BookingServicePeriod $bookingServicePeriod): bool
    {
        return true;
    }
}
