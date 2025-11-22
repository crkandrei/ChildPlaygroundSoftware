<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FiscalReceiptLog extends Model
{
    protected $fillable = [
        'type',
        'play_session_id',
        'play_session_ids',
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
        'play_session_ids' => 'array',
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

    /**
     * Check if this is a combined receipt (has multiple play sessions).
     */
    public function isCombinedReceipt(): bool
    {
        return !is_null($this->play_session_ids) && is_array($this->play_session_ids) && count($this->play_session_ids) > 0;
    }

    /**
     * Get play session IDs as array.
     * Returns array of IDs for combined receipts, or single ID for individual receipts.
     */
    public function getPlaySessionIds(): array
    {
        if ($this->isCombinedReceipt()) {
            return $this->play_session_ids ?? [];
        }
        
        return $this->play_session_id ? [$this->play_session_id] : [];
    }

    /**
     * Get all play sessions associated with this receipt log.
     * Works for both individual and combined receipts.
     */
    public function playSessions()
    {
        $ids = $this->getPlaySessionIds();
        if (empty($ids)) {
            return PlaySession::whereRaw('1 = 0'); // Return empty query
        }
        
        return PlaySession::whereIn('id', $ids);
    }
}
