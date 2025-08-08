<?php

// C:\xampp\htdocs\sicif-api\app\Http\Middleware\CheckRole.php
// Asegúrate de que el contenido sea exactamente así:

namespace App\Http\Middleware; // <-- ¡Este namespace debe ser correcto!

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole // <-- ¡Este nombre de clase debe coincidir con el nombre del archivo!
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Tu lógica de verificación de roles aquí
        // Por ejemplo:
        if (! $request->user() || ! $request->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}