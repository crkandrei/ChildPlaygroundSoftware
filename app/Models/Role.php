<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get the users for the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->name === 'SUPER_ADMIN';
    }

    /**
     * Check if role is company admin
     */
    public function isCompanyAdmin(): bool
    {
        return $this->name === 'COMPANY_ADMIN';
    }

    /**
     * Check if role is staff
     */
    public function isStaff(): bool
    {
        return $this->name === 'STAFF';
    }
}
