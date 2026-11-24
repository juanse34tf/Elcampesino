@extends('layouts.app')

@section('contenido')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Control de Usuarios y Roles
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Gestión de cuentas del personal, roles de acceso y desbloqueo de seguridad
        </p>
    </div>

    <button onclick="document.getElementById('modalCrearUsuario').classList.remove('hidden')"
            class="bg-[#0F3D2F] hover:bg-emerald-900 text-white font-bold px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 text-sm">
        <span>+</span>
        <span>Nuevo Usuario</span>
    </button>
</div>

<!-- FILTROS Y BÚSQUEDA -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.usuarios.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Buscar por nombre o correo</label>
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Ej. Juan, admin@..."
                class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Filtrar por Rol</label>
            <select name="rol" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                <option value="">-- Todos los roles --</option>
                <option value="ADMIN" {{ request('rol') == 'ADMIN' ? 'selected' : '' }}>👑 Administrador</option>
                <option value="EMPLEADO" {{ request('rol') == 'EMPLEADO' ? 'selected' : '' }}>🛒 Empleado / Caja</option>
                <option value="REPARTIDOR" {{ request('rol') == 'REPARTIDOR' ? 'selected' : '' }}>🛵 Repartidor</option>
                <option value="CLIENTE" {{ request('rol') == 'CLIENTE' ? 'selected' : '' }}>👤 Cliente</option>
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="flex-1 bg-[#0F3D2F] text-white font-bold py-2.5 px-4 rounded-xl text-sm hover:bg-emerald-900 transition">
                Filtrar
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- TABLA DE USUARIOS -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Usuario</th>
                    <th class="py-4 px-6">Correo Electrónico</th>
                    <th class="py-4 px-6 text-center">Rol Asignado</th>
                    <th class="py-4 px-6 text-center">Seguridad / Intentos</th>
                    <th class="py-4 px-6 text-center">Estado</th>
                    <th class="py-4 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($usuarios as $usr)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $usr->name }}</p>
                            <p class="text-xs text-slate-400">📞 {{ $usr->telefono ?? 'Sin teléfono' }}</p>
                        </td>
                        <td class="py-4 px-6 font-mono text-xs text-slate-600">
                            {{ $usr->email }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($usr->rol === 'ADMIN')
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-100 text-amber-800">
                                    👑 Administrador
                                </span>
                            @elseif($usr->rol === 'EMPLEADO')
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800">
                                    🛒 Empleado
                                </span>
                            @elseif($usr->rol === 'REPARTIDOR')
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-100 text-blue-800">
                                    🛵 Repartidor
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-100 text-slate-700">
                                    👤 Cliente
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center text-xs">
                            <span class="font-bold {{ $usr->intentos_fallidos >= 3 ? 'text-rose-600' : 'text-slate-600' }}">
                                {{ $usr->intentos_fallidos }} / 3 fallidos
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($usr->bloqueado)
                                <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-rose-100 text-rose-800 animate-pulse">
                                    🔒 Bloqueado
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800">
                                    ✓ Activo
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center space-x-2">
                                <form action="{{ route('admin.usuarios.bloqueo', $usr) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-2.5 py-1 text-xs font-bold rounded-lg border transition
                                            {{ $usr->bloqueado ? 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' : 'border-rose-300 text-rose-700 hover:bg-rose-50' }}"
                                            title="{{ $usr->bloqueado ? 'Desbloquear cuenta' : 'Bloquear cuenta' }}">
                                        {{ $usr->bloqueado ? '🔓 Desbloquear' : '🔒 Bloquear' }}
                                    </button>
                                </form>

                                <button onclick="abrirModalEditarUsuario({{ $usr->id }}, '{{ addslashes($usr->name) }}', '{{ $usr->email }}', '{{ $usr->rol }}', '{{ $usr->telefono }}', '{{ addslashes($usr->direccion) }}')"
                                        class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                                        title="Editar">
                                    ✏️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No se encontraron usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($usuarios->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $usuarios->links() }}
        </div>
    @endif
</div>

<!-- MODAL CREAR USUARIO -->
<div id="modalCrearUsuario" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Registrar Nuevo Usuario</h3>
            <button onclick="document.getElementById('modalCrearUsuario').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre Completo *</label>
                <input type="text" name="name" required placeholder="Ej. Carlos Repartidor" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Correo Electrónico *</label>
                    <input type="email" name="email" required placeholder="usuario@campesino.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Rol de Acceso *</label>
                    <select name="rol" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="EMPLEADO">🛒 Empleado / Caja</option>
                        <option value="ADMIN">👑 Administrador</option>
                        <option value="REPARTIDOR">🛵 Repartidor</option>
                        <option value="CLIENTE">👤 Cliente</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Contraseña Inicial *</label>
                    <input type="password" name="password" required placeholder="Mínimo 6 caracteres" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teléfono</label>
                    <input type="text" name="telefono" placeholder="315..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dirección de Residencia</label>
                <input type="text" name="direccion" placeholder="Calle / Carrera..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalCrearUsuario').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<div id="modalEditarUsuario" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Editar Cuenta de Usuario</h3>
            <button onclick="document.getElementById('modalEditarUsuario').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form id="formEditarUsuario" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre Completo *</label>
                <input type="text" id="edit_usr_name" name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Correo Electrónico *</label>
                    <input type="email" id="edit_usr_email" name="email" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Rol de Acceso *</label>
                    <select id="edit_usr_rol" name="rol" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="EMPLEADO">🛒 Empleado / Caja</option>
                        <option value="ADMIN">👑 Administrador</option>
                        <option value="REPARTIDOR">🛵 Repartidor</option>
                        <option value="CLIENTE">👤 Cliente</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nueva Clave (opcional)</label>
                    <input type="password" name="password" placeholder="En blanco para mantener actual" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teléfono</label>
                    <input type="text" id="edit_usr_telefono" name="telefono" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dirección</label>
                <input type="text" id="edit_usr_direccion" name="direccion" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalEditarUsuario').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalEditarUsuario(id, name, email, rol, telefono, direccion) {
    document.getElementById('formEditarUsuario').action = `/admin/usuarios/${id}`;
    document.getElementById('edit_usr_name').value = name;
    document.getElementById('edit_usr_email').value = email;
    document.getElementById('edit_usr_rol').value = rol;
    document.getElementById('edit_usr_telefono').value = telefono || '';
    document.getElementById('edit_usr_direccion').value = direccion || '';

    document.getElementById('modalEditarUsuario').classList.remove('hidden');
}
</script>

@endsection
