<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repository extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    protected $casts = [
        'user_id' => 'int',
        'active'  => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function builds(): HasMany
    {
        return $this->hasMany(Build::class);
    }
}
