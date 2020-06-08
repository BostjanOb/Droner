<?php

namespace Test\Feature\Http\Controllers;

use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RepositoryController extends TestCase
{
    use RefreshDatabase;

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
