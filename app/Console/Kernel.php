<?php

namespace App\Console;

use App\Console\Commands\CheckBuildStatus;
use App\Console\Commands\RunBuilds;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RunBuilds::class)->everyMinute();

        if (config('droner.pulling')) {
            $schedule->command(CheckBuildStatus::class)->everyMinute();
        }
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
