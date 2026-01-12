<?php

namespace App\Policies;

use App\Models\BookingCalendar;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingCalendarPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, BookingCalendar $bookingCalendar): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, BookingCalendar $bookingCalendar): bool
    {
        return true;
    }

    public function delete(mixed $user, BookingCalendar $bookingCalendar): bool
    {
        return true;
    }

    public function restore(mixed $user, BookingCalendar $bookingCalendar): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, BookingCalendar $bookingCalendar): bool
    {
        return true;
    }
}
