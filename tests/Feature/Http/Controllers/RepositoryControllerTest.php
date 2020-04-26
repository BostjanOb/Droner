<?php

namespace Test\Feature\Http\Controllers;

use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticatedUserCannotViewRepositories()
    {
        $this->getJson('/api/repositories')
            ->assertUnauthorized();
    }

    /** @test */
    public function indexReturnsPaginatedResult()
    {
        $user = factory(User::class)->create();
        $repositories = factory(Repository::class, 5)->create();
        $user->repositories()->sync($repositories->pluck('id'));

        $this->actingAs($user)
            ->getJson('/api/repositories')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'drone_slug', 'git_link', 'active'],
                ],
                'meta' => [
                    'current_page',
                    'per_page',
                    'total',
                ],
            ]);
    }

    /** @test */
    public function notAssignedUserCannotViewRepository()
    {
        $repository = factory(Repository::class)->create();

        $this->getJson('/api/repositories/' . $repository->id)
            ->assertUnauthorized();

        $this->actingAs(factory(User::class)->create())
            ->getJson('/api/repositories/' . $repository->id)
            ->assertForbidden();
    }

    /** @test */
    public function assignedUserCanViewRepository()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create();
        $user->repositories()->attach($repository);

        $this->actingAs($user)
            ->getJson('/api/repositories/' . $repository->id)
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'git_link', 'token'],
            ]);
    }

    /** @test */
    public function notAssignedUserCannotUpdateRepository()
    {
        $repository = factory(Repository::class)->create();

        $this->putJson('/api/repositories/' . $repository->id, ['active' => true, 'threshold' => 5])
            ->assertUnauthorized();

        $this->actingAs(factory(User::class)->create())
            ->putJson('/api/repositories/' . $repository->id, ['active' => true, 'threshold' => 5])
            ->assertForbidden();
    }

    /** @test */
    public function enableRepositoryAssignUserAndGenerateToken()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create();
        $user->repositories()->attach($repository);

        $response = $this->actingAs($user)
            ->putJson('/api/repositories/' . $repository->id, ['active' => true, 'threshold' => 5])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'active',
                    'threshold',
                ],
            ])->decodeResponseJson();

        $this->assertNotNull($response['data']['token']);
        $this->assertEquals(64, strlen($response['data']['token']));

        $this->assertDatabaseHas('repositories', [
            'id'        => $repository->id,
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
        ]);
    }

    /** @test */
    public function enablingDisabledRepositoryDoesntChangeToken()
    {
        $token = Str::random();
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create([
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
            'token'     => $token,
        ]);
        $user->repositories()->attach($repository);

        $this->actingAs($user)
            ->putJson('/api/repositories/' . $repository->id, ['active' => true, 'threshold' => 15])
            ->assertOk();

        $this->assertDatabaseHas('repositories', [
            'id'        => $repository->id,
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 15,
            'token'     => $token,
        ]);
    }

    /** @test */
    public function notAOwnerCannotDeleteRepo()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $repository = factory(Repository::class)->create([
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
            'token'     => Str::random(),
        ]);
        $repository->users()->sync([$user->id, $user1->id]);

        $this->deleteJson('/api/repositories/' . $repository->id)
            ->assertUnauthorized();

        $this->actingAs(factory(User::class)->create())
            ->deleteJson('/api/repositories/' . $repository->id)
            ->assertForbidden();

        $this->actingAs($user1)
            ->deleteJson('/api/repositories/' . $repository->id)
            ->assertForbidden();
    }

    /** @test */
    public function deleteRepoResetsAllFields()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create([
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
            'token'     => Str::random(),
        ]);
        $repository->users()->sync([$user->id]);

        $this->actingAs($user)
            ->deleteJson('/api/repositories/' . $repository->id)
            ->assertNoContent();

        $this->assertDatabaseHas('repositories', [
            'id'        => $repository->id,
            'user_id'   => null,
            'active'    => false,
            'threshold' => null,
            'token'     => null,
        ]);
    }
}
