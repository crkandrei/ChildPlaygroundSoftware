<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyRate extends Model
{
    protected $fillable = [
        'tenant_id',
        'day_of_week',
        'hourly_rate',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'hourly_rate' => 'decimal:2',
    ];

    /**
     * Get the tenant that owns the weekly rate.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get day name in Romanian
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            0 => 'Luni',
            1 => 'Marți',
            2 => 'Miercuri',
            3 => 'Joi',
            4 => 'Vineri',
            5 => 'Sâmbătă',
            6 => 'Duminică',
        ];

        return $days[$this->day_of_week] ?? 'Necunoscut';
    }
}



