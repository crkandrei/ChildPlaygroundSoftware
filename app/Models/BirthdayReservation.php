<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthdayReservation extends Model
{
    protected $fillable = [
        'tenant_id',
        'child_name',
        'guardian_phone',
        'reservation_date',
        'reservation_time',
        'number_of_children',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'number_of_children' => 'integer',
    ];

    /**
     * Get the tenant that owns the reservation.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user who created the reservation.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
