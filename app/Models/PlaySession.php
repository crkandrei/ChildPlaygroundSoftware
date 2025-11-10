<?php

namespace App\Models;

use App\Services\PricingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class PlaySession extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tenant_id',
        'child_id',
        'bracelet_code',
        'started_at',
        'ended_at',
        'calculated_price',
        'price_per_hour_at_calculation',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'calculated_price' => 'decimal:2',
        'price_per_hour_at_calculation' => 'decimal:2',
    ];

    /**
     * Get the tenant that owns the play session.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the child for this play session.
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }


    /** Intervals for this session */
    public function intervals(): HasMany
    {
        return $this->hasMany(PlaySessionInterval::class);
    }

    /** Products for this session */
    public function products(): HasMany
    {
        return $this->hasMany(PlaySessionProduct::class);
    }

    /** Determine if the session is currently active. */
    public function isActive(): bool
    {
        return is_null($this->ended_at);
    }

    /** Determine if the session is currently paused. */
    public function isPaused(): bool
    {
        if (!$this->isActive()) {
            return false;
        }
        // Paused = active session with no open interval
        return !$this->intervals()->whereNull('ended_at')->exists();
    }

    /**
     * Get the current duration in minutes
     */
    public function getCurrentDurationMinutes(): int
    {
        return (int) floor($this->getEffectiveDurationSeconds() / 60);
    }

    /** Total effective duration excluding pauses, in seconds. */
    public function getEffectiveDurationSeconds(): int
    {
        $seconds = 0;
        $intervals = $this->relationLoaded('intervals') ? $this->intervals : $this->intervals()->get();
        foreach ($intervals as $iv) {
            $end = $iv->ended_at ?: now();
            if ($iv->started_at) {
                $seconds += $iv->started_at->diffInSeconds($end);
            }
        }
        return $seconds;
    }

    /** 
     * Get effective duration in seconds for CLOSED intervals only.
     * Excludes the current active interval (if any).
     * This is useful for live timer display on frontend.
     */
    public function getClosedIntervalsDurationSeconds(): int
    {
        $seconds = 0;
        $intervals = $this->relationLoaded('intervals') ? $this->intervals : $this->intervals()->get();
        foreach ($intervals as $iv) {
            // Only count closed intervals
            if ($iv->ended_at && $iv->started_at) {
                $seconds += $iv->started_at->diffInSeconds($iv->ended_at);
            }
        }
        return $seconds;
    }

    /**
     * Get formatted duration string
     */
    public function getFormattedDuration(): string
    {
        $minutes = $this->getCurrentDurationMinutes();
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $remainingMinutes);
        }
        
        return sprintf('%dm', $remainingMinutes);
    }

    /**
     * Start a new play session
     */
    public static function startSession(Tenant $tenant, Child $child, string $braceletCode): self
    {
        $session = self::create([
            'tenant_id' => $tenant->id,
            'child_id' => $child->id,
            'bracelet_code' => $braceletCode,
            'started_at' => now(),
        ]);

        // Create initial open interval
        $session->intervals()->create([
            'started_at' => $session->started_at,
        ]);

        return $session;
    }

    /**
     * End the play session
     */
    public function endSession(): self
    {
        $now = now();
        // Close any open interval
        $open = $this->intervals()->whereNull('ended_at')->latest('started_at')->first();
        if ($open) {
            $duration = $open->started_at ? $open->started_at->diffInSeconds($now) : null;
            $open->update([
                'ended_at' => $now,
                'duration_seconds' => $duration,
            ]);
        }

        $this->update([
            'ended_at' => $now,
        ]);

        // Calculate and save price
        $this->saveCalculatedPrice();

        return $this;
    }

    /** Pause the session by closing the open interval */
    public function pause(): self
    {
        if (!$this->isActive()) {
            throw new \Exception('Sesiunea este deja închisă');
        }
        if ($this->isPaused()) {
            return $this; // already paused
        }
        $now = now();
        $open = $this->intervals()->whereNull('ended_at')->latest('started_at')->first();
        if ($open) {
            $duration = $open->started_at ? $open->started_at->diffInSeconds($now) : null;
            $open->update([
                'ended_at' => $now,
                'duration_seconds' => $duration,
            ]);
        }
        // Session is paused when there's no open interval
        return $this;
    }

    /** Resume the session by starting a new interval */
    public function resume(): self
    {
        if (!$this->isActive()) {
            throw new \Exception('Sesiunea este deja închisă');
        }
        if (!$this->isPaused()) {
            return $this; // already running
        }
        $this->intervals()->create(['started_at' => now()]);
        return $this;
    }

    /**
     * Calculate the price for this session
     * Uses PricingService to calculate based on effective duration and tenant's hourly rate
     * 
     * @return float The calculated price in RON
     */
    public function calculatePrice(): float
    {
        $pricingService = app(PricingService::class);
        return $pricingService->calculateSessionPrice($this);
    }

    /**
     * Get formatted price string for display
     * 
     * @return string Formatted price (e.g., "25.50 RON")
     */
    public function getFormattedPrice(): string
    {
        $price = $this->calculated_price ?? $this->calculatePrice();
        $pricingService = app(PricingService::class);
        return $pricingService->formatPrice($price);
    }

    /**
     * Calculate total price for all products in this session
     * 
     * @return float Total products price in RON
     */
    public function getProductsTotalPrice(): float
    {
        $products = $this->relationLoaded('products') ? $this->products : $this->products()->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->total_price;
        }
        return round($total, 2);
    }

    /**
     * Get total session price including time and products
     * 
     * @return float Total price in RON
     */
    public function getTotalPrice(): float
    {
        $timePrice = $this->calculated_price ?? $this->calculatePrice();
        $productsPrice = $this->getProductsTotalPrice();
        return round($timePrice + $productsPrice, 2);
    }

    /**
     * Get formatted total price string including products
     * 
     * @return string Formatted price (e.g., "35.50 RON")
     */
    public function getFormattedTotalPrice(): string
    {
        $pricingService = app(PricingService::class);
        return $pricingService->formatPrice($this->getTotalPrice());
    }

    /**
     * Save the calculated price with the hourly rate at calculation time
     * This preserves historical pricing even if the tenant's price changes later
     * 
     * @return self
     */
    public function saveCalculatedPrice(): self
    {
        $pricingService = app(PricingService::class);
        $pricingService->calculateAndSavePrice($this);
        return $this;
    }
}

