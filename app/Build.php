<?php

namespace App;

use App\Services\Drone;
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

    public function sendToDrone()
    {
        if ($this->status != self::STATUS_CREATED) {
            throw new \Exception('Only created builds can be send to drone.', 1);
        }

        if ($this->start_at > now()) {
            throw new \Exception('Build not yet scheduled to be send.', 2);
        }

        $droneBuild = (new Drone($this->repository->owner->drone_token))->triggerBuild($this->repository->drone_slug);
        $this->status = self::STATUS_SEND;
        $this->drone_id = $droneBuild['id'];
        $this->started_at = $droneBuild['created'];
        $this->save();

        return $this;
    }
}
