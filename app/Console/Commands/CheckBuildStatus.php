<?php

namespace App\Console\Commands;

use App\Build;
use Illuminate\Console\Command;

class CheckBuildStatus extends Command
{
    protected $signature = 'droner:check-build-status';

    protected $description = 'Check build status for opened builds';

    public function handle()
    {
        Build::whereIn('status', Build::TO_CHECK_STATUS)
            ->get()
            ->each(fn(Build $build) => $build->updateStatusFromDrone());
    }
}
