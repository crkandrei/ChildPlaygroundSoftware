<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'notes',
    ];

    /**
     * Get the tenant that owns the guardian.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the children for the guardian.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }
}
