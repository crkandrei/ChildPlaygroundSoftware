<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    /**
     * Display traffic analysis report
     * Access: SUPER_ADMIN, COMPANY_ADMIN
     */
    public function traffic()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        
        // STAFF nu are acces la rapoarte
        if (Auth::user()->isStaff()) {
            abort(403, 'Acces interzis');
        }
        
        return view('reports.traffic');
    }
}


