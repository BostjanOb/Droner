<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Build extends Model
{
    protected $guarded = [];

    protected $dates = [
        'start_at',
        'started_at',
        'finished_at',
    ];

    public function repository(): BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }
}
