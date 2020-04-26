<?php

namespace Tests\Feature\Http\Controllers;

use App\Build;
use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userWithoutPermissionCanNotViewBuilds()
    {
        $repository = factory(Repository::class)->create();

        $this->getJson("/api/repositories/{$repository->id}/builds")
            ->assertUnauthorized();

        $this->actingAs(factory(User::class)->create())
            ->getJson("/api/repositories/{$repository->id}/builds")
            ->assertForbidden();
    }

    /** @test */
    public function indexReturnPaginatedResultSet()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create();
        factory(Build::class, 10)->create(['repository_id' => $repository->id]);

        $user->repositories()->attach($repository);

        $this->actingAs($user)
            ->getJson("/api/repositories/{$repository->id}/builds")
            ->assertOk();
    }

    /** @test */
    public function userWithoutPermissionCanNoCreateBuild()
    {
        $repository = factory(Repository::class)->create();

        $this->postJson("/api/repositories/{$repository->id}/builds")
            ->assertUnauthorized();

        $this->actingAs(factory(User::class)->create())
            ->postJson("/api/repositories/{$repository->id}/builds")
            ->assertForbidden();
    }

    /** @test */
    public function createNewBuildIfUserHasAccess()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create(['active' => true]);
        $user->repositories()->attach($repository);

        $this->actingAs($user)
            ->postJson("/api/repositories/{$repository->id}/builds")
            ->assertCreated();
    }
}
