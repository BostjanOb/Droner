<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Build extends Model
{
    public const STATUS_CREATED = 'created';
    public const STATUS_SEND = 'send';
    public const STATUS_RUNNING = 'running';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILURE = 'failure';

    public const DRONE_STATUSES = [
        'pending' => self::STATUS_SEND,

        'waiting_on_dependencies' => self::STATUS_RUNNING,
        'running'                 => self::STATUS_RUNNING,

        'success' => self::STATUS_SUCCESS,
        
        'failure'  => self::STATUS_FAILURE,
        'killed'   => self::STATUS_FAILURE,
        'error'    => self::STATUS_FAILURE,
        'skipped'  => self::STATUS_FAILURE,
        'blocked'  => self::STATUS_FAILURE,
        'declined' => self::STATUS_FAILURE,
    ];

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
