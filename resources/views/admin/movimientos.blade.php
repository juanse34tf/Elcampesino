@extends('layouts.app')

@section('contenido')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Kardex y Movimientos
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Auditoría continua de entradas, salidas y ajustes de inventario
        </p>
    </div>

    <button onclick="document.getElementById('modalAjusteInventario').classList.remove('hidden')"
            class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 text-sm">
        <span>⚙️</span>
        <span>Registrar Ajuste / Merma</span>
    </button>
</div>

<!-- FILTROS DE BÚSQUEDA -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.movimientos.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Tipo de Movimiento</label>
            <select name="tipo" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                <option value="">-- Todos los tipos --</option>
                <option value="ENTRADA" {{ request('tipo') == 'ENTRADA' ? 'selected' : '' }}>📥 Entrada</option>
                <option value="SALIDA" {{ request('tipo') == 'SALIDA' ? 'selected' : '' }}>📤 Salida</option>
                <option value="AJUSTE" {{ request('tipo') == 'AJUSTE' ? 'selected' : '' }}>🔄 Ajuste</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Producto</label>
            <select name="producto_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                <option value="">-- Todos los productos --</option>
                @foreach($productos as $prod)
                    <option value="{{ $prod->id }}" {{ request('producto_id') == $prod->id ? 'selected' : '' }}>
                        {{ $prod->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Desde Fecha</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="flex-1 bg-[#0F3D2F] text-white font-bold py-2.5 px-4 rounded-xl text-sm hover:bg-emerald-900 transition">
                Filtrar
            </button>
            <a href="{{ route('admin.movimientos.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- TABLA KARDEX -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Fecha / Hora</th>
                    <th class="py-4 px-6">Tipo</th>
                    <th class="py-4 px-6">Producto y Lote</th>
                    <th class="py-4 px-6 text-center">Cantidad</th>
                    <th class="py-4 px-6">Motivo / Detalle</th>
                    <th class="py-4 px-6 text-right">Usuario Responsable</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($movimientos as $mov)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-xs text-slate-600 font-medium whitespace-nowrap">
                            {{ $mov->created_at->format('d/m/Y h:i A') }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-black rounded-lg
                                {{ $mov->tipo === 'ENTRADA' ? 'bg-emerald-100 text-emerald-800' : ($mov->tipo === 'SALIDA' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $mov->tipo }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $mov->producto->nombre ?? 'N/A' }}</p>
                            <span class="text-[11px] text-slate-400 font-mono">
                                Lote: {{ $mov->lote->numero_lote ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-base
                            {{ $mov->tipo === 'ENTRADA' ? 'text-emerald-700' : ($mov->tipo === 'SALIDA' ? 'text-rose-600' : 'text-amber-700') }}">
                            {{ $mov->tipo === 'ENTRADA' ? '+' : ($mov->tipo === 'SALIDA' ? '-' : '±') }}{{ number_format($mov->cantidad, 2) }}
                            <span class="text-xs text-slate-400 font-normal">{{ $mov->producto->unidad_medida ?? '' }}</span>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ $mov->motivo }}
                        </td>
                        <td class="py-4 px-6 text-right text-xs text-slate-500 font-medium whitespace-nowrap">
                            👤 {{ $mov->usuario->name ?? 'Sistema' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No se encontraron registros de movimiento en el Kardex.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($movimientos->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $movimientos->links() }}
        </div>
    @endif
</div>

<!-- MODAL REGISTRAR AJUSTE DE INVENTARIO -->
<div id="modalAjusteInventario" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-[#0F3D2F]">Ajuste Manual de Inventario</h3>
                <p class="text-xs text-slate-400">Corrección por conteo físico, merma, daño o caducidad</p>
            </div>
            <button onclick="document.getElementById('modalAjusteInventario').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.movimientos.ajuste') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Lote a Ajustar *</label>
                <select name="lote_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                    <option value="">-- Seleccionar Lote --</option>
                    @foreach($lotesDisponibles as $l)
                        <option value="{{ $l->id }}">
                            {{ $l->producto->nombre }} (Lote: {{ $l->numero_lote }} - Stock actual: {{ number_format($l->stock_actual, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Tipo de Ajuste *</label>
                    <select name="tipo_ajuste" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="DISMINUCION">Disminución (Merma / Daño)</option>
                        <option value="INCREMENTO">Incremento (Sobrante Físico)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Cantidad *</label>
                    <input type="number" step="0.01" name="cantidad" required placeholder="Ej. 2.0" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Motivo Justificado *</label>
                <textarea name="motivo" required rows="3" placeholder="Explica la razón del ajuste (ej. Producto con empaque roto en vitrina)..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalAjusteInventario').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-amber-600 text-white rounded-xl text-sm font-bold hover:bg-amber-700 shadow">
                    Aplicar Ajuste
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
