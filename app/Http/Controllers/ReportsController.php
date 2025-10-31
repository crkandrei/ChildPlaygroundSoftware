<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        return view('reports.index');
    }
}


