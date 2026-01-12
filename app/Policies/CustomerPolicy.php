<?php

namespace App\Policies;

use Adultdate\FilamentBooking\Models\Booking\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, Customer $customer): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, Customer $customer): bool
    {
        return true;
    }

    public function delete(mixed $user, Customer $customer): bool
    {
        return true;
    }

    public function restore(mixed $user, Customer $customer): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, Customer $customer): bool
    {
        return true;
    }
}
