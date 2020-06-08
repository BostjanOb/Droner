<?php

namespace Tests\Feature\Http\Livewire\Repository;

use App\Http\Livewire\Repository\Index;
use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticatedUserCannotViewRepositories()
    {
        $user = factory(User::class)->create();
        $repos = factory(Repository::class, 3)->create();
        $unassignedRepos = factory(Repository::class, 3)->create();
        foreach ($repos as $repo) {
            $user->repositories()->attach($repo);
        }

        $index = Livewire::actingAs($user)->test(Index::class);

        foreach ($repos as $repo) {
            $index->assertSee($repo->name);
        }

        foreach ($unassignedRepos as $repo) {
            $index->assertDontSee($repo->name);
        }
    }

    /** @test */
    public function notAssignedUserCannotActivateRepository()
    {
        $repo = factory(Repository::class)->create();
        $user = factory(User::class)->create();

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('activate', $repo->id)
            ->assertForbidden();
    }

    /** @test */
    public function activatingRepositoryAssignUserAndGenerateToken()
    {
        $user = factory(User::class)->create();
        $repo = factory(Repository::class)->create(['user_id' => null]);
        $user->repositories()->attach($repo);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('activate', $repo->id)
            ->assertRedirect(route('repo.edit', ['repo' => $repo]));

        $this->assertDatabaseHas('repositories', [
            'id'        => $repo->id,
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
        ]);

        $repo->refresh();
        $this->assertNotNull($repo->token);
        $this->assertEquals(64, strlen($repo->token));
    }

    /** @test */
    public function activatingDisabledRepositoryDoesntChangeToken()
    {
        $token = Str::random();
        $user = factory(User::class)->create();
        $repo = factory(Repository::class)->create([
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
            'token'     => $token,
        ]);
        $user->repositories()->attach($repo);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('activate', $repo->id)
            ->assertRedirect(route('repo.edit', ['repo' => $repo]));

        $this->assertDatabaseHas('repositories', [
            'id'        => $repo->id,
            'user_id'   => $user->id,
            'active'    => true,
            'threshold' => 5,
            'token'     => $token,
        ]);
    }
}
