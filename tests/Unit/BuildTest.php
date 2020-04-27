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
    public function sendToDroneMakeRequestAnd()
    {
        $time = Carbon::createFromTimestamp(1588023013);
        $build = factory(Build::class)->create([
            'repository_id' => factory(Repository::class)->create(['user_id' => factory(User::class)->create()])->id,
            'status'        => Build::STATUS_CREATED,
            'start_at'      => now()->subMinute(),
        ]);

        Http::fake([
            '*' => Http::response(json_encode(['id' => 1, 'status' => 'pending', 'created' => $time->timestamp]), 200),
        ]);

        $build->sendToDrone();

        $this->assertDatabaseHas('builds', [
            'id'         => $build->id,
            'drone_id'   => 1,
            'status'     => Build::STATUS_SEND,
            'started_at' => $time,
        ]);
    }
}
