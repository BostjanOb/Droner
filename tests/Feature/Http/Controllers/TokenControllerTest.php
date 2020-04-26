<?php

namespace Tests\Feature\Http\Controllers;

use App\Build;
use App\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function indexFailForInvalidToken()
    {
        factory(Repository::class)->create();

        $this->getJson('/api/token', ['Authorization' => 'Bearer john'])
            ->assertNotFound();
    }

    /** @test */
    public function indexReturnsRepositoryWithLatestBuild()
    {
        $token = Str::random();
        $repository = factory(Repository::class)->create([
            'active' => true,
            'token'  => $token,
        ]);

        factory(Build::class, 10)->create(['repository_id' => $repository->id]);

        $this->getJson('/api/token', ['Authorization' => "Bearer {$token}"])
            ->assertOk()
            ->assertJsonCount(5, 'data.builds');
    }

    /** @test */
    public function invalidTokenCannotTriggerBuild()
    {
        factory(Repository::class)->create();

        $this->postJson('/api/token', [], ['Authorization' => 'Bearer john'])
            ->assertNotFound();
    }

    /** @test */
    public function createNewBuildWithValidToken()
    {
        $token = Str::random();
        factory(Repository::class)->create([
            'active' => true,
            'token'  => $token,
        ]);

        $this->postJson('/api/token', [], ['Authorization' => "Bearer {$token}"])
            ->assertCreated();
    }
}
