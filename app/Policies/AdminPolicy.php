<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, Admin $admin): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, Admin $admin): bool
    {
        return true;
    }

    public function delete(mixed $user, Admin $admin): bool
    {
        return true;
    }

    public function restore(mixed $user, Admin $admin): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, Admin $admin): bool
    {
        return true;
    }
}
