<?php

namespace App\Policies;

use App\Repository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Repository $repository): bool
    {
        return $user->repositories()->where('id', $repository->id)->exists();
    }

    public function update(User $user, Repository $repository)
    {
        //
    }

    public function delete(User $user, Repository $repository)
    {
        //
    }
}
