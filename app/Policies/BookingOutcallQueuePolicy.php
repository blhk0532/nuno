<?php

namespace App\Policies;

use App\Models\BookingOutcallQueue;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingOutcallQueuePolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, BookingOutcallQueue $bookingOutcallQueue): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, BookingOutcallQueue $bookingOutcallQueue): bool
    {
        return true;
    }

    public function delete(mixed $user, BookingOutcallQueue $bookingOutcallQueue): bool
    {
        return true;
    }

    public function restore(mixed $user, BookingOutcallQueue $bookingOutcallQueue): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, BookingOutcallQueue $bookingOutcallQueue): bool
    {
        return true;
    }
}
