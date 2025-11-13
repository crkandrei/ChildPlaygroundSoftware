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

        // NOTĂ: Nu mai reînnoim cookie-ul remember me la fiecare request
        // pentru că Auth::login() regenerează sesiunea și invalidează token-ul CSRF
        // 
        // În schimb, ne bazăm pe configurația sesiunii care are lifetime foarte mare
        // (20 ani) și expire_on_close = false, ceea ce asigură că utilizatorul
        // rămâne autentificat fără a regenera sesiunea la fiecare request.
        //
        // Dacă este necesar să reînnoim cookie-ul remember me, ar trebui făcut
        // doar periodic (ex: o dată pe zi) sau când cookie-ul este aproape de expirare,
        // nu la fiecare request.

        return $response;
    }
}

