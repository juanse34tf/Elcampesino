<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Permitir login con correo o con nombre de usuario
        $user = User::where('email', $credentials['email'])
            ->orWhere('name', $credentials['email'])
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        if ($user->bloqueado) {
            return back()->withErrors([
                'email' => 'Esta cuenta se encuentra bloqueada por seguridad tras múltiples intentos fallidos. Contacta al administrador.',
            ])->onlyInput('email');
        }

        if (Hash::check($credentials['password'], $user->password)) {
            $user->update([
                'intentos_fallidos' => 0,
            ]);

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user);
        }

        // Incrementar intentos fallidos
        $intentos = $user->intentos_fallidos + 1;
        $bloqueado = $intentos >= 3;

        $user->update([
            'intentos_fallidos' => $intentos,
            'bloqueado' => $bloqueado,
        ]);

        if ($bloqueado) {
            return back()->withErrors([
                'email' => 'Tu cuenta ha sido bloqueada tras alcanzar 3 intentos fallidos por protocolo de seguridad.',
            ]);
        }

        $restantes = 3 - $intentos;
        return back()->withErrors([
            'email' => "Contraseña incorrecta. Te quedan {$restantes} intento(s) antes del bloqueo de seguridad.",
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    private function redirectBasedOnRole(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->isEmpleado()) {
            return redirect()->intended('/vendedor/dashboard');
        }

        return redirect()->intended('/admin/dashboard');
    }
}
