<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    protected $fillable = [
        'agent_id',
        'tenant_id',
        'activation_code',
        'location_name',
        'printer_serial_number',
        'printer_model',
        'printer_id',
        'printer_status',
        'agent_version',
        'last_heartbeat_at',
        'is_active',
    ];

    protected $casts = [
        'last_heartbeat_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
