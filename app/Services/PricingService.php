<?php

namespace App\Services;

use App\Models\PlaySession;
use App\Models\Tenant;

class PricingService
{
    /**
     * Calculate the price for a play session
     * 
     * @param PlaySession $session
     * @return float The calculated price in RON
     */
    public function calculateSessionPrice(PlaySession $session): float
    {
        $tenant = $session->tenant;
        if (!$tenant) {
            return 0.00;
        }

        $hourlyRate = $this->getHourlyRate($tenant);
        if ($hourlyRate <= 0) {
            return 0.00;
        }

        $durationInHours = $this->getDurationInHours($session);
        $roundedHours = $this->roundToHalfHour($durationInHours);

        return round($roundedHours * $hourlyRate, 2);
    }

    /**
     * Get the hourly rate for a tenant
     * 
     * @param Tenant $tenant
     * @return float The hourly rate in RON
     */
    public function getHourlyRate(Tenant $tenant): float
    {
        return (float) $tenant->price_per_hour ?? 0.00;
    }

    /**
     * Get the effective duration of a session in hours
     * 
     * @param PlaySession $session
     * @return float Duration in hours
     */
    public function getDurationInHours(PlaySession $session): float
    {
        $seconds = $session->getEffectiveDurationSeconds();
        return $seconds / 3600; // Convert seconds to hours
    }

    /**
     * Round duration UP to the nearest half hour (0.5 hours)
     * Minimum duration is 0.5 hours
     * Always rounds up (ceiling)
     * Examples:
     * - 0.1 hours (6 min) -> 0.5 hours (minimum)
     * - 0.26 hours (15.6 min) -> 0.5 hours
     * - 0.52 hours (31 min) -> 1.0 hours (rounded up)
     * - 0.75 hours (45 min) -> 1.0 hours (rounded up)
     * - 1.01 hours (60.6 min) -> 1.5 hours (rounded up)
     * - 1.52 hours (91 min) -> 2.0 hours (rounded up)
     * 
     * @param float $hours
     * @return float Rounded hours UP to nearest 0.5 (minimum 0.5)
     */
    public function roundToHalfHour(float $hours): float
    {
        if ($hours <= 0) {
            return 0.0;
        }

        // Minimum is 0.5 hours
        if ($hours < 0.5) {
            return 0.5;
        }

        // Round UP to nearest 0.5 (ceiling)
        return ceil($hours * 2) / 2;
    }

    /**
     * Format price for display in RON
     * 
     * @param float $price
     * @return string Formatted price string (e.g., "25.50 RON")
     */
    public function formatPrice(float $price): string
    {
        return number_format($price, 2, '.', '') . ' RON';
    }

    /**
     * Calculate and save price for a session
     * This method calculates the price and saves it with the hourly rate at calculation time
     * 
     * @param PlaySession $session
     * @return PlaySession The updated session
     */
    public function calculateAndSavePrice(PlaySession $session): PlaySession
    {
        $tenant = $session->tenant;
        if (!$tenant) {
            return $session;
        }

        $hourlyRate = $this->getHourlyRate($tenant);
        $calculatedPrice = $this->calculateSessionPrice($session);

        $session->update([
            'calculated_price' => $calculatedPrice,
            'price_per_hour_at_calculation' => $hourlyRate,
        ]);

        return $session;
    }
}

