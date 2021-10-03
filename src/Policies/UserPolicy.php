<?php

namespace WriteLabel\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->may('manage_users') || $currentUser->id == $user->id;
    }

    public function delete(User $currentUser, User $user): bool
    {
        return $currentUser->may('manage_users') || $currentUser->id == $user->id;
    }
}
