<?php

namespace App\Policies;

use App\Models\BookingDataLead;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingDataLeadPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, BookingDataLead $bookingDataLead): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, BookingDataLead $bookingDataLead): bool
    {
        return true;
    }

    public function delete(mixed $user, BookingDataLead $bookingDataLead): bool
    {
        return true;
    }

    public function restore(mixed $user, BookingDataLead $bookingDataLead): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, BookingDataLead $bookingDataLead): bool
    {
        return true;
    }
}
