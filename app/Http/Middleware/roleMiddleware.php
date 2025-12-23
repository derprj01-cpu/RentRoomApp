<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class roleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $role): Response
    {
        if (!auth()->check()) {
            abort(401); // belum login
        }

        if (auth()->user()->role !== $role) {
            abort(403); // tidak punya akses
        }

        return $next($request);
    }
}
