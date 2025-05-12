<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Periksa apakah pengguna sudah login dan memiliki peran yang valid
        if (!$user || !in_array($user->role, $roles)) {
            // Jika tidak, redirect atau tampilkan error
            return redirect()->route('main')->with('error', 'Access Denied');
        }

        return $next($request);
    }
}
