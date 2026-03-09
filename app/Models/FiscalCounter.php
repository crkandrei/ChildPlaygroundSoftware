<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiscalCounter extends Model
{
    protected $fillable = [
        'tenant_id',
        'printer_serial',
        'last_receipt_number',
    ];

    protected $casts = [
        'last_receipt_number' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function nextReceiptNumber(): string
    {
        $this->increment('last_receipt_number');
        $this->refresh();

        return str_pad((string) $this->last_receipt_number, 7, '0', STR_PAD_LEFT);
    }
}
