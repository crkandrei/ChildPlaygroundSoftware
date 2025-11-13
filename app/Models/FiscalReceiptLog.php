<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiscalReceiptLog extends Model
{
    protected $fillable = [
        'play_session_id',
        'filename',
        'status',
        'error_message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the play session that owns this fiscal receipt log.
     */
    public function playSession(): BelongsTo
    {
        return $this->belongsTo(PlaySession::class);
    }
}
