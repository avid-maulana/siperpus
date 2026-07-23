<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->level != 6) {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
