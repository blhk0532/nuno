<?php

namespace App\Policies;

use App\Models\TeamInvitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamInvitationPolicy
{
    use HandlesAuthorization;

    public function viewAny(mixed $user): bool
    {
        return true;
    }

    public function view(mixed $user, TeamInvitation $teamInvitation): bool
    {
        return true;
    }

    public function create(mixed $user): bool
    {
        return true;
    }

    public function update(mixed $user, TeamInvitation $teamInvitation): bool
    {
        return true;
    }

    public function delete(mixed $user, TeamInvitation $teamInvitation): bool
    {
        return true;
    }

    public function restore(mixed $user, TeamInvitation $teamInvitation): bool
    {
        return true;
    }

    public function forceDelete(mixed $user, TeamInvitation $teamInvitation): bool
    {
        return true;
    }
}
