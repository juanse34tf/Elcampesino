@extends('layouts.app')

@section('contenido')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Gestión de Inventario
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Catálogo de carnes, pollos y abarrotes con control de existencias
        </p>
    </div>

    <button onclick="document.getElementById('modalCrearProducto').classList.remove('hidden')"
            class="bg-[#0F3D2F] hover:bg-emerald-900 text-white font-bold px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 text-sm">
        <span>+</span>
        <span>Nuevo Producto</span>
    </button>
</div>

<!-- FILTROS Y BÚSQUEDA -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.inventario.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Buscar por nombre o código</label>
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Ej. Pechuga, 7701..."
                class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Filtrar por categoría</label>
            <select name="categoria_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                <option value="">-- Todas las categorías --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="flex-1 bg-[#0F3D2F] text-white font-bold py-2.5 px-4 rounded-xl text-sm hover:bg-emerald-900 transition">
                Filtrar
            </button>
            <a href="{{ route('admin.inventario.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- TABLA DE PRODUCTOS -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Código</th>
                    <th class="py-4 px-6">Producto / Categoría</th>
                    <th class="py-4 px-6 text-right">Precio Venta</th>
                    <th class="py-4 px-6 text-center">Stock Actual</th>
                    <th class="py-4 px-6 text-center">Stock Mínimo</th>
                    <th class="py-4 px-6 text-center">Estado</th>
                    <th class="py-4 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($productos as $prod)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 font-mono text-xs text-slate-500">
                            {{ $prod->codigo_barras ?? 'SIN-CÓDIGO' }}
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $prod->nombre }}</p>
                            <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-bold rounded bg-slate-100 text-slate-600">
                                {{ $prod->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right font-black text-slate-800">
                            ${{ number_format($prod->precio, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="font-bold text-base {{ $prod->estaAgotado() ? 'text-rose-600' : ($prod->estaEnStockBajo() ? 'text-amber-600' : 'text-emerald-700') }}">
                                {{ number_format($prod->stock_total, 2) }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">{{ $prod->unidad_medida }}</span>
                        </td>
                        <td class="py-4 px-6 text-center text-slate-500 font-medium">
                            {{ number_format($prod->stock_minimo, 2) }} {{ $prod->unidad_medida }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if(!$prod->activo)
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-600">
                                    Inactivo
                                </span>
                            @elseif($prod->estaAgotado())
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-rose-100 text-rose-800">
                                    Agotado
                                </span>
                            @elseif($prod->estaEnStockBajo())
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-100 text-amber-800">
                                    Stock Bajo
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800">
                                    Óptimo
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center space-x-2">
                                <button onclick="abrirModalEditar({{ $prod->id }}, '{{ addslashes($prod->nombre) }}', {{ $prod->categoria_id }}, '{{ $prod->codigo_barras }}', {{ $prod->precio }}, {{ $prod->stock_minimo }}, '{{ $prod->unidad_medida }}', {{ $prod->activo ? 'true' : 'false' }})"
                                        class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition"
                                        title="Editar">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.inventario.destroy', $prod) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas retirar este producto del inventario? Su historial permanecerá intacto.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Retirar">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            No se encontraron productos en el catálogo con los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($productos->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $productos->links() }}
        </div>
    @endif
</div>

<!-- MODAL CREAR PRODUCTO -->
<div id="modalCrearProducto" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Nuevo Producto en Catálogo</h3>
            <button onclick="document.getElementById('modalCrearProducto').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.inventario.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre del Producto *</label>
                <input type="text" name="nombre" required placeholder="Ej. Costilla de Cerdo Ahumada" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Categoría *</label>
                    <select name="categoria_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Unidad de Medida *</label>
                    <select name="unidad_medida" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="KG">Kilogramo (KG)</option>
                        <option value="LB">Libra (LB)</option>
                        <option value="UNIDAD">Unidad</option>
                        <option value="PAQUETE">Paquete</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Código de Barras</label>
                <input type="text" name="codigo_barras" placeholder="Opcional - Ej. 7701234567890" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Precio de Venta ($COP) *</label>
                    <input type="number" step="0.01" name="precio" required placeholder="Ej. 18500" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stock Mínimo (Alerta) *</label>
                    <input type="number" step="0.01" name="stock_minimo" required value="5.00" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalCrearProducto').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR PRODUCTO -->
<div id="modalEditarProducto" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F3D2F]">Editar Producto</h3>
            <button onclick="document.getElementById('modalEditarProducto').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form id="formEditarProducto" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nombre del Producto *</label>
                <input type="text" id="edit_nombre" name="nombre" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Categoría *</label>
                    <select id="edit_categoria_id" name="categoria_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Unidad de Medida *</label>
                    <select id="edit_unidad_medida" name="unidad_medida" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="KG">Kilogramo (KG)</option>
                        <option value="LB">Libra (LB)</option>
                        <option value="UNIDAD">Unidad</option>
                        <option value="PAQUETE">Paquete</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Código de Barras</label>
                <input type="text" id="edit_codigo_barras" name="codigo_barras" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Precio de Venta ($COP) *</label>
                    <input type="number" step="0.01" id="edit_precio" name="precio" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Stock Mínimo (Alerta) *</label>
                    <input type="number" step="0.01" id="edit_stock_minimo" name="stock_minimo" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="edit_activo" name="activo" value="1" class="rounded text-[#0F3D2F]">
                <label for="edit_activo" class="text-xs font-bold text-slate-700">Producto activo para la venta</label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalEditarProducto').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Actualizar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalEditar(id, nombre, categoriaId, codigo, precio, stockMin, unidad, activo) {
    document.getElementById('formEditarProducto').action = `/admin/inventario/${id}`;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_categoria_id').value = categoriaId;
    document.getElementById('edit_codigo_barras').value = codigo || '';
    document.getElementById('edit_precio').value = precio;
    document.getElementById('edit_stock_minimo').value = stockMin;
    document.getElementById('edit_unidad_medida').value = unidad;
    document.getElementById('edit_activo').checked = activo;

    document.getElementById('modalEditarProducto').classList.remove('hidden');
}
</script>

@endsection
