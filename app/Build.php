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

    // statuses that are considered "checkable" - running on drone
    public const TO_CHECK_STATUS = [
        self::STATUS_SEND,
        self::STATUS_RUNNING,
    ];

    protected $guarded = [];

    protected $dates = [
        'start_at',
        'send_at',
        'started_at',
        'finished_at',
    ];

    public function repository(): BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }

    public function sendToDrone($force = false): self
    {
        if ($this->status != self::STATUS_CREATED) {
            throw new \Exception('Only created builds can be send to drone.', 1);
        }

        if (!$force && $this->start_at > now()) {
            throw new \Exception('Build not yet scheduled to be send.', 2);
        }

        $droneBuild = (new Drone($this->repository->owner->drone_token))->triggerBuild($this->repository->drone_slug);
        $this->status = self::STATUS_SEND;
        $this->drone_number = $droneBuild['number'];
        $this->send_at = $droneBuild['created'];
        $this->save();

        return $this;
    }

    public function updateStatusFromDrone(): self
    {
        if (!in_array($this->status, self::TO_CHECK_STATUS)) {
            return $this;
        }

        $droneBuild = (new Drone($this->repository->owner->drone_token))
            ->buildInfo($this->repository->drone_slug, $this->drone_number);

        $this->status = self::DRONE_STATUSES[$droneBuild['status']];

        if ($this->status === self::STATUS_RUNNING) {
            $this->started_at = $droneBuild['started'];
        }

        if (!in_array($this->status, self::TO_CHECK_STATUS)) {
            $this->started_at = $droneBuild['started'];
            $this->finished_at = $droneBuild['finished'];
        }

        $this->save();

        return $this;
    }
}
