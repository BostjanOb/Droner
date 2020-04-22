<?php

namespace App\Policies;

use App\Build;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuildPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Build $build)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Build $build)
    {
        //
    }

    public function delete(User $user, Build $build)
    {
        //
    }

    public function restore(User $user, Build $build)
    {
        //
    }

    public function forceDelete(User $user, Build $build)
    {
        //
    }
}
