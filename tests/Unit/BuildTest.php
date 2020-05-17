<?php

namespace Tests\Unit;

use App\Build;
use App\Repository;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BuildTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sendToDroneThrowExceptionWhenStatusNotCreated()
    {
        $build = factory(Build::class)->create(['status' => Build::STATUS_SEND]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode(1);

        $build->sendToDrone();
    }

    /** @test */
    public function sendToDroneThrowExceptionWhenStartAtIsInFeature()
    {
        $build = factory(Build::class)->create(['status' => Build::STATUS_CREATED, 'start_at' => now()->addMinutes(3)]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode(2);

        $build->sendToDrone();
    }

    /** @test */
    public function sendToDroneMakeRequestAndSavesData()
    {
        $time = Carbon::createFromTimestamp(1588023013);
        $build = factory(Build::class)->create([
            'repository_id' => factory(Repository::class)->create(['user_id' => factory(User::class)->create()])->id,
            'status'        => Build::STATUS_CREATED,
            'start_at'      => now()->subMinute(),
        ]);

        Http::fake([
            '*' => Http::response(json_encode(['number' => 1, 'status' => 'pending', 'created' => $time->timestamp]), 200),
        ]);

        $build->sendToDrone();

        $this->assertDatabaseHas('builds', [
            'id'           => $build->id,
            'drone_number' => 1,
            'status'       => Build::STATUS_SEND,
            'send_at'      => $time,
        ]);
    }

    /** @test */
    public function updateStatusFromDroneDoNotDoAnythingWhenStatusIsCompleted()
    {
        Http::assertNothingSent();

        factory(Build::class)
            ->create(['status' => Build::STATUS_CREATED])
            ->updateStatusFromDrone();

        factory(Build::class)
            ->create(['status' => Build::STATUS_FAILURE])
            ->updateStatusFromDrone();

        factory(Build::class)
            ->create(['status' => Build::STATUS_SUCCESS])
            ->updateStatusFromDrone();
    }

    /** @test */
    public function updateStatusFromDroneAndDontSetFinishedWhenStatusIsStillToCheck()
    {
        Http::fake([
            '*' => Http::response(json_encode(['number' => 1, 'status' => 'pending']), 200),
        ]);

        $build = factory(Build::class)->create(['status' => Build::STATUS_SEND, 'drone_number' => 1]);

        $build->updateStatusFromDrone();

        $this->assertEquals(Build::STATUS_SEND, $build->status);
        $this->assertNull($build->finished_at);
    }

    /** @test */
    public function updateStatusFromDroneAndSetNewStatusAndStartedDate()
    {
        Http::fake([
            '*' => Http::response(json_encode(['number' => 1, 'status' => 'running', 'started' => 1564085874]), 200),
        ]);

        $build = factory(Build::class)->create(['status' => Build::STATUS_SEND, 'drone_number' => 1]);

        $build->updateStatusFromDrone();

        $this->assertEquals(Build::STATUS_RUNNING, $build->status);
        $this->assertEquals(1564085874, $build->started_at->timestamp);
        $this->assertNull($build->finished_at);
    }

    /** @test */
    public function updateStatusFromDroneAndSetFinishedAtWhenBuildIsComplete()
    {
        Http::fake([
            '*' => Http::response(json_encode(['number' => 1, 'status' => 'success', 'started' => 1564085874, 'finished' => 1564086343]), 200),
        ]);

        $build = factory(Build::class)->create(['status' => Build::STATUS_RUNNING, 'drone_number' => 1]);

        $build->updateStatusFromDrone();

        $this->assertEquals(Build::STATUS_SUCCESS, $build->status);
        $this->assertEquals(1564085874, $build->started_at->timestamp);
        $this->assertEquals(1564086343, $build->finished_at->timestamp);
    }
}
