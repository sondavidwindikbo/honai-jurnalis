<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
            {
                if (Auth::check() && ! Auth::user()->is_active) {
                    Auth::logout();

                    return redirect('/admin/login')
                        ->withErrors(['email' => 'Akun kamu sudah dinonaktifkan. Hubungi admin.']);
                }

                return $next($request);
            }
}
