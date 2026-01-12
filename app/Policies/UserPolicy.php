<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, User $model): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, User $model): bool
    {
        return true;
    }

    public function delete(mixed $user, User $model): bool
    {
        return true;
    }

    public function restore(mixed $user, User $model): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, User $model): bool
    {
        return true;
    }
}
