@extends('layouts.app')

@section('contenido')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Directorio de Proveedores
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Gestión de aliados comerciales, contactos y trazabilidad de compras
        </p>
    </div>

<<<<<<< HEAD
    <a
    href="/admin/proveedores/nuevo"
    class="bg-[#0F3D2F]
           hover:bg-green-800
           text-white
           px-6
           py-3
           rounded-xl
           inline-block">
    + Nuevo Proveedor
</a>
    

=======
    <button onclick="document.getElementById('modalCrearProveedor').classList.remove('hidden')"
            class="bg-[#0F3D2F] hover:bg-emerald-900 text-white font-bold px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 text-sm">
        <span>+</span>
        <span>Nuevo Proveedor</span>
    </button>
>>>>>>> 4e205096ca1fabbeed6f41a996aa4e7472e31430
</div>

<!-- FILTRO Y BÚSQUEDA -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.proveedores.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Buscar por nombre, NIT o teléfono..."
                class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
        </div>
        <div class="flex items-center space-x-2">
            <button type="submit" class="bg-[#0F3D2F] text-white font-bold py-2.5 px-6 rounded-xl text-sm hover:bg-emerald-900 transition">
                Buscar
            </button>
            <a href="{{ route('admin.proveedores.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- TABLA DE PROVEEDORES -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Empresa / Razón Social</th>
                    <th class="py-4 px-6">NIT / Documento</th>
                    <th class="py-4 px-6">Contacto</th>
                    <th class="py-4 px-6">Ubicación</th>
                    <th class="py-4 px-6 text-center">Compras Registradas</th>
                    <th class="py-4 px-6 text-center">Estado</th>
                    <th class="py-4 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($proveedores as $prov)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $prov->nombre }}</p>
                        </td>
                        <td class="py-4 px-6 font-mono text-xs text-slate-600">
                            {{ $prov->nit_cedula ?? 'No registrado' }}
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            <p class="font-medium text-slate-800">📞 {{ $prov->telefono ?? 'S/T' }}</p>
                            <p class="text-slate-400">✉️ {{ $prov->email ?? 'S/C' }}</p>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ $prov->direccion ?? 'Cali / Valle' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-block px-2.5 py-1 text-xs font-black rounded-lg bg-blue-50 text-blue-700">
                                {{ $prov->lotes_count }} lote(s)
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg {{ $prov->activo ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $prov->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center space-x-2">
                                <button onclick="abrirModalEditarProveedor({{ $prov->id }}, '{{ addslashes($prov->nombre) }}', '{{ $prov->nit_cedula }}', '{{ $prov->telefono }}', '{{ $prov->email }}', '{{ addslashes($prov->direccion) }}', {{ $prov->activo ? 'true' : 'false' }})"
                                        class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                                        title="Editar">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.proveedores.destroy', $prov) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas desactivar este proveedor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Desactivar">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            No se encontraron proveedores registrados con los criterios de búsqueda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($proveedores->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $proveedores->links() }}
        </div>
    @endif
</div>

<!-- MODAL CREAR PROVEEDOR -->
<div id="modalCrearProveedor" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Registrar Nuevo Proveedor</h3>
            <button onclick="document.getElementById('modalCrearProveedor').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.proveedores.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre o Razón Social *</label>
                <input type="text" name="nombre" required placeholder="Ej. Avícola Santa Anita S.A." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">NIT / Cédula</label>
                    <input type="text" name="nit_cedula" placeholder="900.123.456-7" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teléfono</label>
                    <input type="text" name="telefono" placeholder="310 123 4567" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Correo Electrónico</label>
                <input type="email" name="email" placeholder="contacto@proveedor.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dirección / Sede</label>
                <input type="text" name="direccion" placeholder="Calle / Zona Industrial..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalCrearProveedor').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Guardar Proveedor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR PROVEEDOR -->
<div id="modalEditarProveedor" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Editar Proveedor</h3>
            <button onclick="document.getElementById('modalEditarProveedor').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form id="formEditarProveedor" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre o Razón Social *</label>
                <input type="text" id="edit_prov_nombre" name="nombre" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">NIT / Cédula</label>
                    <input type="text" id="edit_prov_nit" name="nit_cedula" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teléfono</label>
                    <input type="text" id="edit_prov_telefono" name="telefono" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Correo Electrónico</label>
                <input type="email" id="edit_prov_email" name="email" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Dirección / Sede</label>
                <input type="text" id="edit_prov_direccion" name="direccion" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="edit_prov_activo" name="activo" value="1" class="rounded text-[#0F3D2F]">
                <label for="edit_prov_activo" class="text-xs font-bold text-slate-700">Proveedor activo</label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalEditarProveedor').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Actualizar Proveedor
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalEditarProveedor(id, nombre, nit, telefono, email, direccion, activo) {
    document.getElementById('formEditarProveedor').action = `/admin/proveedores/${id}`;
    document.getElementById('edit_prov_nombre').value = nombre;
    document.getElementById('edit_prov_nit').value = nit || '';
    document.getElementById('edit_prov_telefono').value = telefono || '';
    document.getElementById('edit_prov_email').value = email || '';
    document.getElementById('edit_prov_direccion').value = direccion || '';
    document.getElementById('edit_prov_activo').checked = activo;

    document.getElementById('modalEditarProveedor').classList.remove('hidden');
}
</script>

@endsection
