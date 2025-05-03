<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCookieConsent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->cookies->has('cookie_consent')) {
            return redirect()->route('home')
                            ->with('error',
                                'Halaman tersebut harus menyetujui penggunaan cookie.'
                            );
        }

        return $next($request);
    }
}
