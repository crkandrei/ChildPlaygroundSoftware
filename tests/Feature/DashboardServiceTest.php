<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\Guardian;
use App\Models\PlaySession;
use App\Models\Tenant;
use App\Repositories\Eloquent\ChildRepository;
use App\Repositories\Eloquent\PlaySessionRepository;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    private DashboardService $service;
    private Tenant $tenant;
    private Child $child;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardService(
            new PlaySessionRepository(),
            new ChildRepository()
        );
        $this->tenant = Tenant::factory()->create(['price_per_hour' => 40]);
        $guardian = Guardian::factory()->create(['tenant_id' => $this->tenant->id]);
        $this->child = Child::factory()->create([
            'tenant_id' => $this->tenant->id,
            'guardian_id' => $guardian->id,
        ]);
    }

    public function test_get_stats_returns_correct_active_and_today_counts(): void
    {
        // 2 active (fără ended_at), 1 terminată
        PlaySession::factory()->count(2)->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now(),
            'ended_at' => null,
        ]);
        PlaySession::factory()->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now()->subHour(),
            'ended_at' => now(),
        ]);

        $stats = $this->service->getStatsForTenant($this->tenant->id);

        $this->assertEquals(2, $stats['active_sessions']);
        $this->assertEquals(3, $stats['sessions_today']);
        $this->assertEquals(2, $stats['sessions_today_in_progress']);
    }
}
