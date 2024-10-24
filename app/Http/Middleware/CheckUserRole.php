<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        
        // Convertimos los roles pasados a enteros para evitar problemas de tipo
        $roles = array_map('intval', $roles);

        // Verifica si el rol del usuario está en el array de roles permitidos
        if (in_array(Auth::user()->rol_id, $roles)) {
            return $next($request);
        }

        // Redirigir si no tiene el rol requerido
        return redirect('/unauthorized')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
