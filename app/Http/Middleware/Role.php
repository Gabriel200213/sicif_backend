<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->user()->rol !== $role) {
            return response()->json(['message' => 'Acceso no autorizado'], 403);
        }
        return $next($request);
    }
}
?>