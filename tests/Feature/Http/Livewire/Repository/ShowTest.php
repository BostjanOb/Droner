<?php

namespace Tests\Feature\Http\Livewire\Repository;

use App\Http\Livewire\Repository\Show;
use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notAssignedUserCannotViewRepository()
    {
        $repo = factory(Repository::class)->create();

        Livewire::test(Show::class, ['repo' => $repo])
            ->assertForbidden();

        Livewire::actingAs(factory(User::class)->create())
            ->test(Show::class, ['repo' => $repo])
            ->assertForbidden();
    }

    /** @test */
    public function assignedUserCanViewRepository()
    {
        $user = factory(User::class)->create();
        $repo = factory(Repository::class)->create();
        $user->repositories()->attach($repo);

        Livewire::actingAs($user)
            ->test(Show::class, ['repo' => $repo])
            ->assertSee($repo->name);
    }

    /** @test */
    public function createNewBuildIfUserHasAccess()
    {
        $user = factory(User::class)->create();
        $repo = factory(Repository::class)->create(['active' => true]);
        $user->repositories()->attach($repo);

        Livewire::actingAs($user)
            ->test(Show::class, ['repo' => $repo])
            ->call('queue')
            ->assertDispatchedBrowserEvent('toast', [
                'title'   => 'New build successfully queued',
                'type'    => 'success',
                'timeout' => 2000,
            ]);

        $this->assertDatabaseCount('builds', 1);
    }
}
