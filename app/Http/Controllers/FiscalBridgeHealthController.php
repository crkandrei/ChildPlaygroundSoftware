<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Support\ApiResponder;
use Illuminate\Support\Facades\Auth;

class FiscalBridgeHealthController extends Controller
{
    /**
     * Check fiscal bridge health status
     */
    public function check()
    {
        $user = Auth::user();
        if (!$user || !$user->isSuperAdmin()) {
            return ApiResponder::error('Acces permis doar pentru super admin', 403);
        }

        $bridgeUrl = config('services.fiscal_bridge.url', 'http://localhost:9000');
        $timeout = 3; // 3 seconds timeout

        try {
            $response = Http::timeout($timeout)->get("{$bridgeUrl}/health");
            
            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => 'alive',
                        'bridge_status' => $data['status'] ?? 'unknown',
                        'timestamp' => $data['timestamp'] ?? now()->toISOString(),
                    ],
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => 'dead',
                        'error' => 'Bridge returned non-200 status',
                    ],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'dead',
                    'error' => $e->getMessage(),
                ],
            ]);
        }
    }
}

