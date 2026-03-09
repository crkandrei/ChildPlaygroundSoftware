<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\FiscalCounter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentApiController extends Controller
{
    public function activate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'activationCode' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
        ]);

        $activationCode = $validated['activationCode'] ?? $validated['code'] ?? null;
        if (!$activationCode) {
            return response()->json([
                'message' => 'Activation code is required.',
            ], 422);
        }

        $agent = Agent::query()
            ->where('activation_code', $activationCode)
            ->where('is_active', true)
            ->first();

        if (!$agent) {
            return response()->json([
                'message' => 'Activation code invalid.',
            ], 404);
        }

        return response()->json([
            'agentId' => $agent->agent_id,
            'clientId' => $agent->tenant_id,
            'locationName' => $agent->location_name ?? ($agent->tenant?->name ?? null),
            'cloudBaseUrl' => config('app.url'),
        ]);
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'agentId' => 'required|string|max:255',
            'version' => 'required|string|max:50',
            'printerStatus' => 'required|in:online,offline',
            'printerModel' => 'nullable|string|max:255',
            'printerId' => 'nullable|string|max:255',
            'serialNumber' => 'nullable|string|max:255',
            'timestamp' => 'required|date',
        ]);

        $agent = Agent::query()
            ->where('agent_id', $validated['agentId'])
            ->where('is_active', true)
            ->first();

        if (!$agent) {
            return response()->json([
                'message' => 'Unknown agent.',
            ], 404);
        }

        $serialNumber = $validated['serialNumber'] ?? $agent->printer_serial_number ?? $validated['printerId'] ?? null;

        $agent->update([
            'agent_version' => $validated['version'],
            'printer_status' => $validated['printerStatus'],
            'printer_model' => $validated['printerModel'] ?? null,
            'printer_id' => $validated['printerId'] ?? null,
            'printer_serial_number' => $serialNumber,
            'last_heartbeat_at' => now(),
        ]);

        if ($serialNumber) {
            FiscalCounter::query()->updateOrCreate(
                ['tenant_id' => $agent->tenant_id],
                ['printer_serial' => strtoupper($serialNumber)]
            );
        }

        return response()->json([
            'ok' => true,
        ]);
    }

    public function version(): JsonResponse
    {
        return response()->json([
            'version' => config('app.hopo_agent_version', '1.0.0'),
        ]);
    }
}
