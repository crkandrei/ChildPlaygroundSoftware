<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware care reînnoiește automat cookie-ul "remember me"
 * pentru a preveni delogarea utilizatorilor
 * 
 * Acest middleware asigură că utilizatorii rămân autentificați
 * chiar dacă browser-ul are limitări pentru cookie-uri persistente (~400 zile)
 */
class RefreshRememberToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Dacă utilizatorul este autentificat, reînnoiește cookie-ul "remember me"
        // Acest lucru asigură că utilizatorul rămâne autentificat chiar dacă
        // browser-ul are limitări pentru cookie-uri persistente
        if (Auth::check()) {
            $user = Auth::user();
            
            // Reînnoiește cookie-ul "remember me" pentru a preveni expirarea
            // Folosim login() cu remember=true pentru a reînnoi cookie-ul
            // fără a regenera sesiunea (pentru a evita probleme de performanță)
            Auth::login($user, true);
        }

        return $response;
    }
}

