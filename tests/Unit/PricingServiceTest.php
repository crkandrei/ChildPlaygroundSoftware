<?php

namespace Tests\Unit;

use App\Models\PlaySession;
use App\Models\Tenant;
use App\Services\PricingService;
use Tests\TestCase;
use Mockery;

class PricingServiceTest extends TestCase
{
    protected PricingService $pricingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pricingService = new PricingService();
    }

    /**
     * Test că prima oră se taxează întotdeauna ca 1 oră completă
     */
    public function test_first_hour_always_charged_as_full_hour(): void
    {
        // 10 minute -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(10 / 60));
        
        // 20 minute -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(20 / 60));
        
        // 40 minute -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(40 / 60));
        
        // 59 minute -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(59 / 60));
        
        // Exact 1 oră -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(1.0));
    }

    /**
     * Test că timpul sub 15 minute peste prima oră se rotunjește în jos
     */
    public function test_under_15_minutes_over_first_hour_rounds_down(): void
    {
        // 1:05 (1h 5min) -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(1.0 + 5 / 60));
        
        // 1:10 (1h 10min) -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(1.0 + 10 / 60));
        
        // 1:14 (1h 14min) -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(1.0 + 14 / 60));
        
        // 1:14.99 (1h 14.99min) -> 1.0 ore
        $this->assertEquals(1.0, $this->pricingService->roundToHalfHour(1.0 + 14.99 / 60));
    }

    /**
     * Test că timpul între 15 și 30 minute (inclusiv) se taxează ca jumătate de oră
     */
    public function test_between_15_and_30_minutes_charges_half_hour(): void
    {
        // 1:15 (1h 15min) -> 1.5 ore
        $this->assertEquals(1.5, $this->pricingService->roundToHalfHour(1.0 + 15 / 60));
        
        // 1:20 (1h 20min) -> 1.5 ore
        $this->assertEquals(1.5, $this->pricingService->roundToHalfHour(1.0 + 20 / 60));
        
        // 1:25 (1h 25min) -> 1.5 ore
        $this->assertEquals(1.5, $this->pricingService->roundToHalfHour(1.0 + 25 / 60));
        
        // 1:30 (1h 30min) -> 1.5 ore
        $this->assertEquals(1.5, $this->pricingService->roundToHalfHour(1.0 + 30 / 60));
    }

    /**
     * Test că timpul peste 30 minute se taxează ca o oră completă
     */
    public function test_over_30_minutes_charges_full_hour(): void
    {
        // 1:31 (1h 31min) -> 2.0 ore
        $this->assertEquals(2.0, $this->pricingService->roundToHalfHour(1.0 + 31 / 60));
        
        // 1:35 (1h 35min) -> 2.0 ore
        $this->assertEquals(2.0, $this->pricingService->roundToHalfHour(1.0 + 35 / 60));
        
        // 1:45 (1h 45min) -> 2.0 ore
        $this->assertEquals(2.0, $this->pricingService->roundToHalfHour(1.0 + 45 / 60));
        
        // 1:59 (1h 59min) -> 2.0 ore
        $this->assertEquals(2.0, $this->pricingService->roundToHalfHour(1.0 + 59 / 60));
        
        // Exact 2 ore -> 2.0 ore (nu ar trebui să se întâmple în practică pentru că 1h + 60min = 2h)
        $this->assertEquals(2.0, $this->pricingService->roundToHalfHour(2.0));
    }

    /**
     * Test că durata zero sau negativă returnează 0
     */
    public function test_zero_or_negative_duration_returns_zero(): void
    {
        $this->assertEquals(0.0, $this->pricingService->roundToHalfHour(0.0));
        $this->assertEquals(0.0, $this->pricingService->roundToHalfHour(-1.0));
    }

    /**
     * Test calcul preț complet pentru o sesiune
     */
    public function test_calculate_session_price(): void
    {
        $tenant = new Tenant();
        $tenant->price_per_hour = 50.00;

        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = $tenant;
        $session->shouldReceive('getEffectiveDurationSeconds')
            ->andReturn(3600); // 1 oră exactă

        $price = $this->pricingService->calculateSessionPrice($session);
        
        // 1 oră * 50 RON = 50 RON
        $this->assertEquals(50.00, $price);
    }

    /**
     * Test calcul preț pentru sesiune de 1:15 (1.5 ore)
     */
    public function test_calculate_session_price_one_hour_fifteen_minutes(): void
    {
        $tenant = new Tenant();
        $tenant->price_per_hour = 50.00;

        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = $tenant;
        $session->shouldReceive('getEffectiveDurationSeconds')
            ->andReturn(4500); // 1:15 = 75 minute = 4500 secunde

        $price = $this->pricingService->calculateSessionPrice($session);
        
        // 1.5 ore * 50 RON = 75 RON
        $this->assertEquals(75.00, $price);
    }

    /**
     * Test calcul preț pentru sesiune de 1:10 (1.0 ore)
     */
    public function test_calculate_session_price_one_hour_ten_minutes(): void
    {
        $tenant = new Tenant();
        $tenant->price_per_hour = 50.00;

        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = $tenant;
        $session->shouldReceive('getEffectiveDurationSeconds')
            ->andReturn(4200); // 1:10 = 70 minute = 4200 secunde

        $price = $this->pricingService->calculateSessionPrice($session);
        
        // 1.0 ore * 50 RON = 50 RON (rotunjit în jos)
        $this->assertEquals(50.00, $price);
    }

    /**
     * Test calcul preț pentru sesiune de 1:35 (2.0 ore)
     */
    public function test_calculate_session_price_one_hour_thirty_five_minutes(): void
    {
        $tenant = new Tenant();
        $tenant->price_per_hour = 50.00;

        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = $tenant;
        $session->shouldReceive('getEffectiveDurationSeconds')
            ->andReturn(5700); // 1:35 = 95 minute = 5700 secunde

        $price = $this->pricingService->calculateSessionPrice($session);
        
        // 2.0 ore * 50 RON = 100 RON
        $this->assertEquals(100.00, $price);
    }

    /**
     * Test că sesiunea fără tenant returnează preț 0
     */
    public function test_session_without_tenant_returns_zero_price(): void
    {
        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = null;

        $price = $this->pricingService->calculateSessionPrice($session);
        
        $this->assertEquals(0.00, $price);
    }

    /**
     * Test că sesiunea cu tenant fără preț returnează preț 0
     */
    public function test_session_with_tenant_without_price_returns_zero_price(): void
    {
        $tenant = new Tenant();
        $tenant->price_per_hour = null;

        $session = Mockery::mock(PlaySession::class)->makePartial();
        $session->shouldAllowMockingProtectedMethods();
        $session->tenant = $tenant;

        $price = $this->pricingService->calculateSessionPrice($session);
        
        $this->assertEquals(0.00, $price);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

