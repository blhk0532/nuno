<?php

namespace App\Policies;

use Adultdate\FilamentBooking\Models\Booking\DailyLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyLocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, DailyLocation $dailyLocation): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, DailyLocation $dailyLocation): bool
    {
        return true;
    }

    public function delete(mixed $user, DailyLocation $dailyLocation): bool
    {
        return true;
    }

    public function restore(mixed $user, DailyLocation $dailyLocation): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, DailyLocation $dailyLocation): bool
    {
        return true;
    }
}
