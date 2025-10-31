<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bracelet extends Model
{
    protected $fillable = [
        'tenant_id',
        'code',
        'child_id',
        'status',
        'assigned_at',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the bracelet.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the child that owns the bracelet.
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Get the scan events for the bracelet.
     */
    public function scanEvents(): HasMany
    {
        return $this->hasMany(ScanEvent::class);
    }

    /**
     * Check if bracelet is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if bracelet is assigned
     */
    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Check if bracelet is lost
     */
    public function isLost(): bool
    {
        return $this->status === 'lost';
    }

    /**
     * Check if bracelet is damaged
     */
    public function isDamaged(): bool
    {
        return $this->status === 'damaged';
    }
}
