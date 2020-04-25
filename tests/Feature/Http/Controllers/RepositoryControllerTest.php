<?php

namespace Test\Feature\Http\Controllers;


use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
    use RefreshDatabase;

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

        $user->repositories()->sync([$repository->id]);

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

}
