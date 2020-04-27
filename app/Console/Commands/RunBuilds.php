<?php

namespace App\Console\Commands;

use App\Build;
use Illuminate\Console\Command;

class RunBuilds extends Command
{
    protected $signature = 'droner:run-builds';

    protected $description = 'Run scheduled builds';

    public function handle()
    {
        Build::where('status', Build::STATUS_CREATED)
            ->where('start_at', '<=', now())
            ->with(['repository'])
            ->get()
            ->each(fn(Build $b) => $b->sendToDrone());
    }
}
