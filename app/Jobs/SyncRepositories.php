<?php

namespace App\Jobs;

use App\Repository;
use App\Services\Drone;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncRepositories
{
    use Dispatchable;
    use Queueable;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $repositories = (new Drone($this->user->drone_token))->userRepositories();
        $repositories->each(
            fn($repository) => Repository::updateOrCreate(
                ['id' => $repository['id']],
                [
                    'name'       => $repository['name'],
                    'drone_slug' => $repository['slug'],
                    'git_link'   => $repository['link'],
                ]
            )
        );

        $this->user->repositories()->sync($repositories->pluck('id'));
    }
}
