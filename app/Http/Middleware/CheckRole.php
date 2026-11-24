<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Debes iniciar sesión para continuar.']);
        }

        $user = Auth::user();

        if ($user->bloqueado) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Tu cuenta ha sido bloqueada por seguridad. Contacta al administrador.']);
        }

        if (!empty($roles) && !in_array($user->rol, $roles)) {
            abort(403, 'No tienes permisos para acceder a este módulo.');
        }

        return $next($request);
    }
}
