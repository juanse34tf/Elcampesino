<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::latest();

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->input('rol'));
        }

        $usuarios = $query->paginate(15)->withQueryString();

        return view('admin.usuarios', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'rol' => ['required', Rule::in(['ADMIN', 'EMPLEADO'])],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['intentos_fallidos'] = 0;
        $validated['bloqueado'] = false;

        User::create($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario registrado exitosamente.');
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($usuario->id)],
            'rol' => ['required', Rule::in(['ADMIN', 'EMPLEADO'])],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function toggleBloqueo(User $usuario): RedirectResponse
    {
        $nuevoEstado = !$usuario->bloqueado;
        $usuario->update([
            'bloqueado' => $nuevoEstado,
            'intentos_fallidos' => $nuevoEstado ? 3 : 0,
        ]);

        $mensaje = $nuevoEstado ? "Usuario {$usuario->name} bloqueado." : "Usuario {$usuario->name} desbloqueado e intentos reiniciados.";

        return redirect()->route('admin.usuarios.index')->with('success', $mensaje);
    }
}
