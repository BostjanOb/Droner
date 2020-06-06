<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Response;

class Repository extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'user_id' => 'int',
        'active'  => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function latestBuild(): HasOne
    {
        return $this->hasOne(Build::class)->latest()->take(1);
    }

    public function builds(): HasMany
    {
        return $this->hasMany(Build::class);
    }

    public function newBuild()
    {
        abort_unless($this->active, Response::HTTP_FORBIDDEN, 'Repository is not activated');

        $lastBuild = $this->builds()->where('status', Build::STATUS_CREATED)->first();
        abort_if($lastBuild !== null && now() < $lastBuild->start_at, Response::HTTP_TOO_MANY_REQUESTS, 'Another build already queued!');

        return $this->builds()->create([
            'status'   => Build::STATUS_CREATED,
            'start_at' => now()->addMinutes($this->threshold),
        ]);
    }
}
