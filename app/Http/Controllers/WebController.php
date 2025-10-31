<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    /**
     * Show dashboard
     */
    public function dashboard()
    {
        $user = Auth::user()->load(['role', 'tenant']);
        return view('dashboard', compact('user'));
    }

    /**
     * Redirect root to login or dashboard
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return redirect('/login');
    }
}
