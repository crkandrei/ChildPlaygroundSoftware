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

    public function test_get_alerts_detects_long_sessions(): void
    {
        // Sesiune activă de 5 ore (ar trebui în alerte)
        PlaySession::factory()->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now()->subHours(5),
            'ended_at' => null,
        ]);

        // Sesiune activă de 1 oră (nu ar trebui în alerte)
        PlaySession::factory()->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now()->subHour(),
            'ended_at' => null,
        ]);

        $alerts = $this->service->getAlerts($this->tenant->id);

        $longSessionAlerts = collect($alerts)->firstWhere('type', 'long_session');
        $this->assertNotNull($longSessionAlerts);
        $this->assertEquals(1, $longSessionAlerts['count']);
    }

    public function test_avg_session_duration_excludes_sessions_older_than_90_days(): void
    {
        // Sesiune din acum 5 zile (60 minute) — trebuie inclusă
        PlaySession::factory()->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now()->subDays(5)->subHour(),
            'ended_at' => now()->subDays(5),
        ]);
        // Sesiune din acum 120 de zile (120 minute) — trebuie EXCLUSĂ
        PlaySession::factory()->create([
            'tenant_id' => $this->tenant->id,
            'child_id' => $this->child->id,
            'started_at' => now()->subDays(120)->subHours(2),
            'ended_at' => now()->subDays(120),
        ]);

        $stats = $this->service->getStatsForTenant($this->tenant->id);

        // Dacă sesiunea de 120 de zile ar fi inclusă, media ar fi 90 min
        // Dacă e exclusă corect, media = 60 min ± 2
        $this->assertEqualsWithDelta(60, $stats['avg_session_total_minutes'], 2);
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
