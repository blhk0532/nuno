<?php

namespace App\Policies;

use App\Models\Team;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, Team $team): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, Team $team): bool
    {
        return true;
    }

    public function delete(mixed $user, Team $team): bool
    {
        return true;
    }

    public function restore(mixed $user, Team $team): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, Team $team): bool
    {
        return true;
    }
}
