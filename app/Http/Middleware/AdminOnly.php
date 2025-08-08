<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user();
        if ($user && $user->id_rol === 1) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No tienes permisos para realizar esta acción'
        ], 403);
    }
}