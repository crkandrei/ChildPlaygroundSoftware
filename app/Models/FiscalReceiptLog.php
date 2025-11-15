<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiscalReceiptLog extends Model
{
    protected $fillable = [
        'type',
        'play_session_id',
        'tenant_id',
        'filename',
        'status',
        'error_message',
        'voucher_hours',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'voucher_hours' => 'decimal:2',
    ];

    /**
     * Get the play session that owns this fiscal receipt log.
     */
    public function playSession(): BelongsTo
    {
        return $this->belongsTo(PlaySession::class);
    }

    /**
     * Get the tenant that owns this fiscal receipt log (for Z reports).
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
