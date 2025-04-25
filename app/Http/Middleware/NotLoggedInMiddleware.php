<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotLoggedInMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() || Auth::viaRemember()) {
            if (Auth::user()->role === 'super_admin') {
                return redirect()->route('super-admin.dashboard.index');
            } else {
                return redirect()->route('admin.dashboard.index');
            }
        }

        return $next($request);
    }
}
