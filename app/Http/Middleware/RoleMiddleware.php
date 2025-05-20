<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
  public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

}
