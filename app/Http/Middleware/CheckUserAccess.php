<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado y si su acceso no está validado
        if (Auth::check() && Auth::user()->validated == 0) {
            // Si el acceso no está validado, cerrar la sesión y redirigir al login
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu acceso ha sido invalidado.');
        }

        return $next($request);
    }
}
