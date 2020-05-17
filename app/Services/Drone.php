<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Drone
{
    private string $token;
    private string $url;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->url = config('droner.drone_url');
    }

    public function userRepositories(): Collection
    {
        return collect($this->callDroneApi('get', 'user/repos'))->filter(fn($r) => $r['active']);
    }

    public function triggerBuild(string $repoSlug): array
    {
        return $this->callDroneApi('post', "repos/{$repoSlug}/builds");
    }

    public function buildInfo(string $repoSlug, int $buildNumber): array
    {
        return $this->callDroneApi('get', "repos/$repoSlug/builds/$buildNumber");
    }

    private function callDroneApi(string $method, string $endpoint, array $params = [])
    {
        $response = Http::withToken($this->token)
            ->$method($this->url . '/api' . Str::start($endpoint, '/'), $params);

        if (!$response->successful()) {
            throw new \Exception($response->body(), $response->status());
        }

        return $response->json();
    }
}
