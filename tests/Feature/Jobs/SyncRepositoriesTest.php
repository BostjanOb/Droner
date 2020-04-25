<?php

namespace Tests\Feature\Jobs;

use App\Jobs\SyncRepositories;
use App\Repository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SyncRepositoriesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function throwExceptionWhenRequestFails()
    {
        Http::fake([
            '*' => Http::response('{"message":"Unauthorized"}', 401),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('{"message":"Unauthorized"}');
        $this->expectExceptionCode(401);

        (new SyncRepositories(factory(User::class)->make()))->handle();
    }

    /** @test */
    public function addNewRepositoriesAndLinkedThemToUser()
    {
        $user = factory(User::class)->create();

        $response = json_encode([
            [
                'id'     => 1,
                'name'   => 'Repo 1',
                'slug'   => 'NameSpace/Repo1',
                'link'   => 'https://github.com/NameSpace/Repo1',
                'active' => true,
            ],
            [
                'id'     => 2,
                'name'   => 'Repo 2',
                'slug'   => 'NameSpace/Repo2',
                'link'   => 'https://github.com/NameSpace/Repo2',
                'active' => true,
            ],
            [
                'id'     => 3,
                'name'   => 'Repo 3',
                'slug'   => 'NameSpace/Repo3',
                'link'   => 'https://github.com/NameSpace/Repo3',
                'active' => false,
            ],
        ]);

        Http::fake([
            '*' => Http::response($response, 200),
        ]);

        (new SyncRepositories($user))->handle();

        $this->assertEquals(2, Repository::count());
        $this->assertCount(2, $user->repositories);

        $this->assertDatabaseHas('repository_user', ['user_id' => $user->id, 'repository_id' => 1,]);
        $this->assertDatabaseHas('repositories', ['id' => 2, 'name' => 'Repo 2']);
    }

    /** @test */
    public function addNewRepositoryRenameAndAssingOldOne()
    {
        $user = factory(User::class)->create();
        factory(Repository::class)->create(
            [
                'id'       => 1,
                'name'     => $this->faker->name,
                'git_link' => 'https://github.com/NameSpace/Repo1',
            ]
        );

        $response = json_encode([
            [
                'id'     => 1,
                'name'   => 'Repo 1',
                'slug'   => 'NameSpace/Repo1',
                'link'   => 'https://github.com/NameSpace/Repo1',
                'active' => true,
            ],
            [
                'id'     => 2,
                'name'   => 'Repo 2',
                'slug'   => 'NameSpace/Repo2',
                'link'   => 'https://github.com/NameSpace/Repo2',
                'active' => true,
            ],
        ]);

        Http::fake([
            '*' => Http::response($response, 200),
        ]);

        (new SyncRepositories($user))->handle();

        $this->assertEquals(2, Repository::count());
        $this->assertCount(2, $user->repositories);

        $this->assertDatabaseHas('repository_user', ['user_id' => $user->id, 'repository_id' => 1,]);
        $this->assertDatabaseHas('repositories', ['id' => 1, 'name' => 'Repo 1']);
    }

    /** @test */
    public function unlinkRepositoryFromUserWhenInactive()
    {
        $user = factory(User::class)->create();
        factory(Repository::class)->create(
            [
                'id'       => 1,
                'name'     => 'Repo 1',
                'git_link' => 'https://github.com/NameSpace/Repo1',
            ]
        );

        $response = json_encode([
            [
                'id'     => 1,
                'name'   => 'Repo 1',
                'slug'   => 'NameSpace/Repo1',
                'link'   => 'https://github.com/NameSpace/Repo1',
                'active' => false,
            ],
            [
                'id'     => 2,
                'name'   => 'Repo 2',
                'slug'   => 'NameSpace/Repo2',
                'link'   => 'https://github.com/NameSpace/Repo2',
                'active' => true,
            ],
        ]);

        Http::fake([
            '*' => Http::response($response, 200),
        ]);

        (new SyncRepositories($user))->handle();

        $this->assertEquals(2, Repository::count());
        $this->assertCount(1, $user->repositories);

        $this->assertDatabaseMissing('repository_user', ['user_id' => $user->id, 'repository_id' => 1,]);
        $this->assertDatabaseHas('repositories', ['id' => 1, 'name' => 'Repo 1']);
    }

    /** @test */
    public function unlinkRepositoryFromUserWhenRemoved()
    {
        $user = factory(User::class)->create();
        factory(Repository::class)->create(
            [
                'id'       => 1,
                'name'     => 'Repo 1',
                'git_link' => 'https://github.com/NameSpace/Repo1',
            ]
        );

        $response = json_encode([
            [
                'id'     => 2,
                'name'   => 'Repo 2',
                'slug'   => 'NameSpace/Repo2',
                'link'   => 'https://github.com/NameSpace/Repo2',
                'active' => true,
            ],
        ]);

        Http::fake([
            '*' => Http::response($response, 200),
        ]);

        (new SyncRepositories($user))->handle();

        $this->assertEquals(2, Repository::count());
        $this->assertCount(1, $user->repositories);

        $this->assertDatabaseMissing('repository_user', ['user_id' => $user->id, 'repository_id' => 1,]);
        $this->assertDatabaseHas('repositories', ['id' => 1, 'name' => 'Repo 1']);
    }
}
