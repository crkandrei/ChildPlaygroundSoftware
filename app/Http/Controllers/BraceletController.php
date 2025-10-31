<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use App\Models\Child;
use App\Support\ActionLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BraceletController extends Controller
{
    /**
     * Display a listing of bracelets
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        $bracelets = Bracelet::where('tenant_id', $tenant->id)
            ->with(['child.guardian'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bracelets.index', compact('bracelets'));
    }

    /**
     * Show the form for creating a new bracelet
     */
    public function create()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        return view('bracelets.create');
    }

    /**
     * Store a newly created bracelet
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'Utilizatorul nu este asociat cu niciun tenant');
        }

        $request->validate([
            'code' => 'nullable|string|size:10|unique:bracelets,code',
        ]);

        // Generate code if not provided
        $code = $request->code ?: $this->generateUniqueCode();

        $bracelet = Bracelet::create([
            'tenant_id' => $tenant->id,
            'code' => $code,
            'child_id' => null,
            'status' => 'available',
            'assigned_at' => null,
            'notes' => null,
        ]);

        ActionLogger::logCrud('created', 'Bracelet', $bracelet->id, [
            'code' => $code,
            'status' => $bracelet->status,
        ]);

        return redirect()->route('bracelets.index')->with('success', 'Brățara a fost adăugată cu succes');
    }

    /**
     * Display the specified bracelet
     */
    public function show(Bracelet $bracelet)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $bracelet->tenant_id !== $tenant->id) {
            return redirect()->route('bracelets.index')->with('error', 'Brățara nu a fost găsită');
        }

        $bracelet->load(['child.guardian', 'scanEvents' => function($query) {
            $query->orderBy('scanned_at', 'desc')->limit(20);
        }]);

        return view('bracelets.show', compact('bracelet'));
    }

    /**
     * Show the form for editing the specified bracelet
     */
    public function edit(Bracelet $bracelet)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $bracelet->tenant_id !== $tenant->id) {
            return redirect()->route('bracelets.index')->with('error', 'Brățara nu a fost găsită');
        }

        // Load children to allow assignment when bracelet is not currently assigned
        $children = Child::where('tenant_id', $tenant->id)
            ->with('guardian')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('bracelets.edit', compact('bracelet', 'children'));
    }

    /**
     * Update the specified bracelet
     */
    public function update(Request $request, Bracelet $bracelet)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $bracelet->tenant_id !== $tenant->id) {
            return redirect()->route('bracelets.index')->with('error', 'Brățara nu a fost găsită');
        }

        if ($bracelet->isAssigned()) {
            // When assigned, no changes allowed via update (only unassign action)
            return redirect()->route('bracelets.index')->with('error', 'Nu se pot face modificări când brățara este asignată');
        } else {
            // When not assigned, allow code and optional assignment to a child
            $request->validate([
                'code' => 'required|string|size:10|unique:bracelets,code,' . $bracelet->id,
                'child_id' => 'nullable|integer|exists:children,id',
            ]);

            // Ensure provided child (if any) belongs to the same tenant
            $childId = $request->input('child_id');
            if ($childId) {
                $child = Child::where('id', $childId)->where('tenant_id', $tenant->id)->first();
                if (!$child) {
                    return back()->withErrors(['child_id' => 'Copil invalid pentru acest tenant'])->withInput();
                }
            }

            $updateData = [
                'code' => $request->code,
            ];

            if ($childId) {
                $updateData['child_id'] = $childId;
                $updateData['status'] = 'assigned';
                $updateData['assigned_at'] = now();
            } else {
                $updateData['child_id'] = null;
                $updateData['status'] = 'available';
                $updateData['assigned_at'] = null;
            }

            $bracelet->update($updateData);
        }

        ActionLogger::logAudit('updated', 'Bracelet', $bracelet->id, [
            'previous_status' => $bracelet->getOriginal('status'),
            'previous_child_id' => $bracelet->getOriginal('child_id'),
        ], [
            'status' => $bracelet->status,
            'child_id' => $bracelet->child_id,
            'code' => $bracelet->code,
        ]);

        return redirect()->route('bracelets.index')->with('success', 'Brățara a fost actualizată cu succes');
    }

    /**
     * Remove the specified bracelet
     */
    public function destroy(Bracelet $bracelet)
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        if (!$tenant || $bracelet->tenant_id !== $tenant->id) {
            return redirect()->route('bracelets.index')->with('error', 'Brățara nu a fost găsită');
        }

        // Check if bracelet is assigned
        if ($bracelet->isAssigned()) {
            return redirect()->route('bracelets.index')->with('error', 'Nu se poate șterge brățara - este asignată unui copil');
        }

        $braceletData = [
            'code' => $bracelet->code,
            'status' => $bracelet->status,
        ];

        $bracelet->delete();

        ActionLogger::logCrud('deleted', 'Bracelet', $bracelet->id, $braceletData);

        return redirect()->route('bracelets.index')->with('success', 'Brățara a fost ștearsă cu succes');
    }

    /**
     * Unassign the specified bracelet from its child
     */
    public function unassign(Bracelet $bracelet)
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant || $bracelet->tenant_id !== $tenant->id) {
            return redirect()->route('bracelets.index')->with('error', 'Brățara nu a fost găsită');
        }

        if (!$bracelet->isAssigned()) {
            return redirect()->route('bracelets.index')->with('info', 'Brățara nu este asignată');
        }

        $bracelet->update([
            'child_id' => null,
            'status' => 'available',
            'assigned_at' => null,
        ]);

        ActionLogger::log('bracelet.unassigned', 'Bracelet', $bracelet->id, [
            'code' => $bracelet->code,
        ]);

        return redirect()->route('bracelets.index')->with('success', 'Brățara a fost dezasignată cu succes');
    }

    /**
     * Generate unique bracelet code
     */
    private function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(10));
        } while (Bracelet::where('code', $code)->exists());

        return $code;
    }
}
