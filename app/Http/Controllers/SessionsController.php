<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PlaySessionRepositoryInterface;
use App\Support\ApiResponder;
use App\Models\PlaySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct(private PlaySessionRepositoryInterface $sessions)
    {
    }
    /** Show sessions page */
    public function index()
    {
        return view('sessions.index');
    }

    /** Server-side data for sessions table */
    public function data(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            return ApiResponder::error('Neautentificat sau fără tenant', 401);
        }

        $tenantId = $user->tenant->id;

        // Inputs
        $page = max(1, (int) $request->input('page', 1));
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort_by', 'started_at');
        $sortDir = strtolower((string) $request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Allowed sorting columns map to SQL columns
        $result = $this->sessions->paginateSessions(
            $tenantId,
            $page,
            $perPage,
            $search === '' ? null : $search,
            $sortBy,
            $sortDir
        );

        return ApiResponder::success([
            'data' => $result['rows'],
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $result['total'],
                'total_pages' => (int) ceil($result['total'] / max(1, $perPage)),
                'sort_by' => $sortBy,
                'sort_dir' => $sortDir,
                'search' => $search,
            ],
        ]);
    }

    /** Show session details */
    public function show($id)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            return redirect()->route('login');
        }

        $session = PlaySession::where('id', $id)
            ->where('tenant_id', $user->tenant->id)
            ->with(['child.guardian', 'bracelet', 'intervals' => function($query) {
                $query->orderBy('started_at', 'asc');
            }])
            ->first();

        if (!$session) {
            abort(404, 'Sesiunea nu a fost găsită');
        }

        return view('sessions.show', compact('session'));
    }

    /** Generate receipt for session */
    public function receipt($id)
    {
        $user = Auth::user();
        if (!$user || !$user->tenant) {
            abort(401, 'Neautentificat');
        }

        $session = PlaySession::where('id', $id)
            ->where('tenant_id', $user->tenant->id)
            ->with(['child.guardian', 'bracelet', 'tenant', 'intervals' => function($query) {
                $query->orderBy('started_at', 'asc');
            }])
            ->first();

        if (!$session) {
            abort(404, 'Sesiunea nu a fost găsită');
        }

        if (!$session->ended_at) {
            abort(400, 'Bonul poate fi generat doar pentru sesiuni finalizate');
        }

        // Ensure price is calculated
        if (!$session->calculated_price) {
            $session->saveCalculatedPrice();
            $session->refresh();
        }

        return view('sessions.receipt', compact('session'));
    }
}


