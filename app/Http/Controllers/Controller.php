<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * Get the home route for the authenticated user based on their role
     */
    protected function getHomeRoute(): string
    {
        if (Auth::check() && Auth::user()->isStaff()) {
            return '/scan';
        }
        return '/dashboard';
    }

    /**
     * Redirect to home route based on user role
     */
    protected function redirectToHome()
    {
        return redirect($this->getHomeRoute());
    }
}
