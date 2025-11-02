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
     * Round duration according to pricing rules:
     * - First hour: always charged as 1 full hour (regardless of actual duration)
     * - After first hour: specific rounding rules apply
     * 
     * Rules:
     * - Duration ≤ 1 hour → 1.0 hours (always)
     * - Duration > 1 hour:
     *   - Additional time < 15 minutes → round down (1.0 hours total)
     *   - Additional time ≥ 15 minutes and ≤ 30 minutes → add 0.5 hours (1.5 hours total)
     *   - Additional time > 30 minutes → add 1 hour (2.0 hours total)
     * 
     * Examples:
     * - 0.17 hours (10 min) -> 1.0 hours (first hour always full)
     * - 0.67 hours (40 min) -> 1.0 hours (first hour always full)
     * - 1.17 hours (1h 10min) -> 1.0 hours (10 min < 15 min, rounded down)
     * - 1.25 hours (1h 15min) -> 1.5 hours (15 min = 15 min, add 0.5 hours)
     * - 1.33 hours (1h 20min) -> 1.5 hours (20 min between 15-30 min, add 0.5 hours)
     * - 1.5 hours (1h 30min) -> 1.5 hours (30 min = 30 min, add 0.5 hours)
     * - 1.58 hours (1h 35min) -> 2.0 hours (35 min > 30 min, add 1 hour)
     * - 1.75 hours (1h 45min) -> 2.0 hours (45 min > 30 min, add 1 hour)
     * 
     * @param float $hours Duration in hours
     * @return float Rounded hours according to pricing rules
     */
    public function roundToHalfHour(float $hours): float
    {
        if ($hours <= 0) {
            return 0.0;
        }

        // First hour: always charged as 1 full hour
        if ($hours <= 1.0) {
            return 1.0;
        }

        // Calculate minutes over the first hour
        $minutesOverHour = ($hours - 1.0) * 60;

        // Apply rounding rules for additional time
        if ($minutesOverHour < 15) {
            // Less than 15 minutes: round down (stay at 1 hour)
            return 1.0;
        } elseif ($minutesOverHour <= 30) {
            // Between 15 and 30 minutes (inclusive): add 0.5 hours
            return 1.5;
        } else {
            // More than 30 minutes: add 1 hour
            return 2.0;
        }
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

