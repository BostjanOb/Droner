<?php

namespace Tests\Unit;

use App\Build;
use App\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function returnForbiddenForInactiveRepository()
    {
        $repository = factory(Repository::class)->create(['active' => false, 'threshold' => 10]);

        try {
            $repository->newBuild();
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());

            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function returnTooManyRequestsIfSubmittedToFast()
    {
        $repository = factory(Repository::class)->create(['active' => true, 'threshold' => 10]);

        factory(Build::class)->create([
            'repository_id' => $repository->id,
            'status'        => 'created',
            'start_at'      => now()->addMinutes(2),
        ]);

        try {
            $repository->newBuild();
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_TOO_MANY_REQUESTS, $e->getStatusCode());

            return;
        }

        $this->fail('Exception not thrown');
    }


    /** @test */
    public function createNewBuildIfFirst()
    {
        $repository = factory(Repository::class)->create(['active' => true]);

        $build = $repository->newBuild();

        $this->assertInstanceOf(Build::class, $build);
    }

    /** @test */
    public function createNewBuildIfThresholdPassed()
    {
        $repository = factory(Repository::class)->create(['active' => true, 'threshold' => 10]);

        factory(Build::class)->create([
            'repository_id' => $repository->id,
            'status'        => 'created',
            'start_at'      => now()->subMinute(),
        ]);

        $build = $repository->newBuild();

        $this->assertInstanceOf(Build::class, $build);
    }
}
