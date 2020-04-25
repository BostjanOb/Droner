<?php

namespace App\Jobs;

use App\Repository;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;

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
        $request = Http::withToken($this->user->token)
            ->get(env('DRONE_URL') . '/api/user/repos');

        if (!$request->successful()) {
            throw new \Exception($request->body(), $request->status());
        }

        $repositories = collect($request->json())->filter(fn($r) => $r['active']);
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
