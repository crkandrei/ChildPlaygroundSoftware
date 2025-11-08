<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaySessionInterval extends Model
{
    protected $table = 'play_session_intervals';

    protected $fillable = [
        'play_session_id',
        'started_at',
        'ended_at',
        'duration_seconds',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function playSession(): BelongsTo
    {
        return $this->belongsTo(PlaySession::class);
    }
}






