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
     * - After first hour: specific rounding rules apply for each additional hour and remaining minutes
     * 
     * Rules:
     * - Duration ≤ 1 hour → 1.0 hours (always)
     * - Duration > 1 hour:
     *   - First hour: always 1.0 hours
     *   - Each complete hour after the first: add 1.0 hours
     *   - Remaining minutes after complete hours:
     *     - < 15 minutes → round down (no additional charge)
     *     - ≥ 15 minutes and ≤ 30 minutes → add 0.5 hours
     *     - > 30 minutes → add 1.0 hours
     * 
     * Examples:
     * - 0.17 hours (10 min) -> 1.0 hours (first hour always full)
     * - 0.67 hours (40 min) -> 1.0 hours (first hour always full)
     * - 1.17 hours (1h 10min) -> 1.0 hours (10 min < 15 min, rounded down)
     * - 1.25 hours (1h 15min) -> 1.5 hours (15 min = 15 min, add 0.5 hours)
     * - 1.33 hours (1h 20min) -> 1.5 hours (20 min between 15-30 min, add 0.5 hours)
     * - 1.5 hours (1h 30min) -> 1.5 hours (30 min = 30 min, add 0.5 hours)
     * - 1.58 hours (1h 35min) -> 2.0 hours (35 min > 30 min, add 1 hour)
     * - 2.0 hours (2h 0min) -> 2.0 hours (1 + 1 complete hours)
     * - 2.17 hours (2h 10min) -> 2.0 hours (1 + 1 complete + 10min < 15min)
     * - 2.25 hours (2h 15min) -> 2.5 hours (1 + 1 complete + 15min = 0.5h)
     * - 2.58 hours (2h 35min) -> 3.0 hours (1 + 1 complete + 35min > 30min = +1h)
     * - 8.0 hours (8h 0min) -> 8.0 hours (1 + 7 complete hours)
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

        // Calculate complete hours after the first hour
        $completeHoursAfterFirst = floor($hours - 1.0);
        
        // Calculate remaining minutes after complete hours
        $remainingMinutes = (($hours - 1.0) - $completeHoursAfterFirst) * 60;

        // Start with first hour (always 1.0)
        $totalHours = 1.0;
        
        // Add complete hours after the first
        $totalHours += $completeHoursAfterFirst;

        // Apply rounding rules for remaining minutes
        if ($remainingMinutes < 15) {
            // Less than 15 minutes: round down (no additional charge)
            // Total hours remain as calculated
        } elseif ($remainingMinutes <= 30) {
            // Between 15 and 30 minutes (inclusive): add 0.5 hours
            $totalHours += 0.5;
        } else {
            // More than 30 minutes: add 1 hour
            $totalHours += 1.0;
        }

        return $totalHours;
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

