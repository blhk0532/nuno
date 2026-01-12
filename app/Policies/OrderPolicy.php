<?php

namespace App\Policies;

use Adultdate\FilamentBooking\Models\Booking\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, Order $order): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, Order $order): bool
    {
        return true;
    }

    public function delete(mixed $user, Order $order): bool
    {
        return true;
    }

    public function restore(mixed $user, Order $order): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, Order $order): bool
    {
        return true;
    }
}
