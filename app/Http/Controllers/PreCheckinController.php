<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Guardian;
use App\Models\PreCheckinToken;
use App\Models\Tenant;
use App\Support\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class PreCheckinController extends Controller
{
    private const QR_TTL_MINUTES = 30;
    private const MAX_ACTIVE_QRS_PER_TENANT = 100;

    /**
     * Show the pre-checkin landing page (phone input).
     */
    public function index(string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pre-checkin.index', compact('tenant'));
    }

    /**
     * Look up a guardian by phone number.
     */
    public function lookup(Request $request, string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $key = 'pc-lookup:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return ApiResponder::error('Prea multe încercări. Încearcă din nou în câteva minute.', 429);
        }
        RateLimiter::hit($key, 60);

        $request->validate(['phone' => 'required|string|max:20']);

        $phone = $this->normalizePhone($request->phone);

        $guardian = Guardian::where('tenant_id', $tenant->id)
            ->where('phone', $phone)
            ->with('children')
            ->first();

        if (!$guardian) {
            return ApiResponder::success(['found' => false]);
        }

        return ApiResponder::success([
            'found' => true,
            'guardian' => [
                'id' => $guardian->id,
                'name' => $guardian->name,
            ],
            'children' => $guardian->children->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
            ])->values(),
            'needs_terms' => $guardian->needsToAcceptLegalDocuments(),
        ]);
    }

    /**
     * Register a new guardian + child and return a QR token.
     */
    public function register(Request $request, string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $key = 'pc-register:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return ApiResponder::error('Prea multe înregistrări. Încearcă din nou în câteva minute.', 429);
        }
        RateLimiter::hit($key, 600);

        // Honeypot anti-bot field
        if ($request->filled('website')) {
            return ApiResponder::success(['token' => strtoupper(Str::random(8))]);
        }

        $request->validate([
            'guardian_name'  => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'child_name'     => 'required|string|max:100',
            'terms_accepted' => 'accepted',
            'gdpr_accepted'  => 'accepted',
        ]);

        if ($this->tenantAtCapacity($tenant->id)) {
            return ApiResponder::error('Sistemul este ocupat. Încearcă din nou în câteva minute.', 503);
        }

        $phone = $this->normalizePhone($request->phone);

        try {
            $token = DB::transaction(function () use ($request, $tenant, $phone) {
                $existing = Guardian::where('tenant_id', $tenant->id)->where('phone', $phone)->first();
                if ($existing) {
                    throw new \Exception('Există deja un cont cu acest număr de telefon. Întoarce-te și caută după număr.');
                }

                $guardian = Guardian::create([
                    'tenant_id'        => $tenant->id,
                    'name'             => $this->normalizeName($request->guardian_name),
                    'phone'            => $phone,
                    'terms_accepted_at' => now(),
                    'gdpr_accepted_at'  => now(),
                    'terms_version'    => LegalController::TERMS_VERSION,
                    'gdpr_version'     => LegalController::GDPR_VERSION,
                ]);

                $child = Child::create([
                    'tenant_id'     => $tenant->id,
                    'guardian_id'   => $guardian->id,
                    'name'          => $this->normalizeName($request->child_name),
                    'internal_code' => $this->generateInternalCode($request->child_name),
                ]);

                return $this->createToken($tenant->id, $guardian->id, $child->id);
            });

            return ApiResponder::success(['token' => $token->token]);
        } catch (\Exception $e) {
            return ApiResponder::error($e->getMessage(), 400);
        }
    }

    /**
     * Generate a QR token for an existing guardian's child.
     */
    public function generateQr(Request $request, string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $key = 'pc-qr:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return ApiResponder::error('Prea multe generări. Încearcă din nou în câteva minute.', 429);
        }
        RateLimiter::hit($key, 600);

        $request->validate([
            'guardian_id' => 'required|integer',
            'child_id'    => 'required|integer',
        ]);

        if ($this->tenantAtCapacity($tenant->id)) {
            return ApiResponder::error('Sistemul este ocupat. Încearcă din nou în câteva minute.', 503);
        }

        $guardian = Guardian::where('id', $request->guardian_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$guardian) {
            return ApiResponder::error('Datele nu au fost găsite.', 404);
        }

        if ($guardian->needsToAcceptLegalDocuments()) {
            return response()->json([
                'success'     => false,
                'needs_terms' => true,
                'message'     => 'Trebuie să accepți termenii înainte de a genera un QR.',
            ], 422);
        }

        $child = Child::where('id', $request->child_id)
            ->where('guardian_id', $guardian->id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$child) {
            return ApiResponder::error('Copilul nu a fost găsit.', 404);
        }

        $token = $this->createToken($tenant->id, $guardian->id, $child->id);

        return ApiResponder::success(['token' => $token->token]);
    }

    /**
     * Add a new child for an existing guardian and generate a QR token.
     */
    public function addChild(Request $request, string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $key = 'pc-add-child:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return ApiResponder::error('Prea multe cereri. Încearcă din nou în câteva minute.', 429);
        }
        RateLimiter::hit($key, 600);

        $request->validate([
            'guardian_id' => 'required|integer',
            'child_name'  => 'required|string|max:100',
            'birth_date'  => 'nullable|date|before:today',
            'allergies'   => 'nullable|string|max:500',
        ]);

        $guardian = Guardian::where('id', $request->guardian_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$guardian) {
            return ApiResponder::error('Datele nu au fost găsite.', 404);
        }

        if ($guardian->needsToAcceptLegalDocuments()) {
            return response()->json([
                'success'     => false,
                'needs_terms' => true,
                'message'     => 'Trebuie să accepți termenii înainte de a adăuga un copil.',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $tenant, $guardian) {
                $child = Child::create([
                    'tenant_id'     => $tenant->id,
                    'guardian_id'   => $guardian->id,
                    'name'          => $this->normalizeName($request->child_name),
                    'birth_date'    => $request->birth_date ?: null,
                    'allergies'     => $request->allergies ?: null,
                    'internal_code' => $this->generateInternalCode($request->child_name),
                ]);

                $token = $this->createToken($tenant->id, $guardian->id, $child->id);

                return ['child' => $child, 'token' => $token];
            });

            return ApiResponder::success([
                'token' => $result['token']->token,
                'child' => [
                    'id'   => $result['child']->id,
                    'name' => $result['child']->name,
                ],
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error($e->getMessage(), 400);
        }
    }

    /**
     * Accept / re-accept legal documents for an existing guardian.
     */
    public function acceptTerms(Request $request, string $slug)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $request->validate([
            'guardian_id'    => 'required|integer',
            'terms_accepted' => 'accepted',
            'gdpr_accepted'  => 'accepted',
        ]);

        $guardian = Guardian::where('id', $request->guardian_id)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$guardian) {
            return ApiResponder::error('Datele nu au fost găsite.', 404);
        }

        $guardian->update([
            'terms_accepted_at' => now(),
            'gdpr_accepted_at'  => now(),
            'terms_version'     => LegalController::TERMS_VERSION,
            'gdpr_version'      => LegalController::GDPR_VERSION,
        ]);

        return ApiResponder::success(['message' => 'Termenii au fost acceptați.']);
    }

    /**
     * Show the QR code display page (client-facing).
     */
    public function showQr(string $slug, string $token)
    {
        $tenant = Tenant::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $preCheckin = PreCheckinToken::where('token', strtoupper($token))
            ->where('tenant_id', $tenant->id)
            ->with(['guardian', 'child'])
            ->first();

        if (!$preCheckin) {
            return view('pre-checkin.qr', [
                'tenant'     => $tenant,
                'preCheckin' => null,
                'error'      => 'QR code invalid.',
            ]);
        }

        if ($preCheckin->isUsed()) {
            return view('pre-checkin.qr', [
                'tenant'     => $tenant,
                'preCheckin' => null,
                'error'      => 'Acest QR code a fost deja folosit. Generează unul nou.',
            ]);
        }

        if ($preCheckin->isExpired()) {
            return view('pre-checkin.qr', [
                'tenant'     => $tenant,
                'preCheckin' => null,
                'error'      => 'Acest QR code a expirat. Generează unul nou.',
            ]);
        }

        return view('pre-checkin.qr', [
            'tenant'     => $tenant,
            'preCheckin' => $preCheckin,
            'error'      => null,
        ]);
    }

    /**
     * Staff endpoint: validate a pre-checkin token and return guardian + child data.
     * Called from the scan page (requires auth).
     */
    public function lookupToken(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->tenant) {
            return ApiResponder::error('Neautentificat.', 401);
        }

        $request->validate(['token' => 'required|string|max:64']);

        $tokenValue = strtoupper(trim($request->token));

        $preCheckin = PreCheckinToken::where('token', $tokenValue)
            ->where('tenant_id', $user->tenant->id)
            ->with(['guardian', 'child'])
            ->first();

        if (!$preCheckin) {
            return ApiResponder::error('QR code invalid sau nu aparține acestei locații.', 404);
        }

        if ($preCheckin->isUsed()) {
            return ApiResponder::error('Acest QR code a fost deja folosit.', 400);
        }

        if ($preCheckin->isExpired()) {
            $expiredAt = $preCheckin->expires_at->format('H:i');
            return ApiResponder::error("QR code expirat la {$expiredAt}. Rugați clientul să genereze unul nou.", 400);
        }

        return ApiResponder::success([
            'precheckin_id' => $preCheckin->id,
            'guardian' => [
                'id'    => $preCheckin->guardian->id,
                'name'  => $preCheckin->guardian->name,
                'phone' => $preCheckin->guardian->phone,
            ],
            'child' => [
                'id'            => $preCheckin->child->id,
                'name'          => $preCheckin->child->name,
                'internal_code' => $preCheckin->child->internal_code,
            ],
            'expires_at'      => $preCheckin->expires_at->toISOString(),
            'expires_seconds' => $preCheckin->secondsUntilExpiry(),
        ]);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function createToken(int $tenantId, int $guardianId, int $childId): PreCheckinToken
    {
        // Invalidate any still-active tokens for this child
        PreCheckinToken::where('child_id', $childId)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->update(['expires_at' => now()]);

        return PreCheckinToken::create([
            'tenant_id'   => $tenantId,
            'guardian_id' => $guardianId,
            'child_id'    => $childId,
            'token'       => strtoupper(Str::random(8)),
            'expires_at'  => now()->addMinutes(self::QR_TTL_MINUTES),
        ]);
    }

    private function tenantAtCapacity(int $tenantId): bool
    {
        return PreCheckinToken::where('tenant_id', $tenantId)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->count() >= self::MAX_ACTIVE_QRS_PER_TENANT;
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/\s+/', '', $phone);
    }

    private function normalizeName(string $name): string
    {
        return strtoupper(trim($name));
    }

    private function generateInternalCode(string $childName): string
    {
        $part = strtoupper(substr(preg_replace('/\s+/', '', trim($childName)), 0, 4));
        return $part . rand(100, 999);
    }
}
