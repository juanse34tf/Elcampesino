@extends('layouts.app')

@section('contenido')

<div class="mb-8">
    <h1 class="text-3xl font-black text-[#0F3D2F]">
        Punto de Consulta y Caja (Vendedor)
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Consulta ágil de existencias, precios y disponibilidad en mostrador
    </p>
</div>

<!-- FILTROS Y BÚSQUEDA RÁPIDA -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <form action="{{ route('vendedor.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Buscar por nombre o código</label>
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Pechuga, lomo, frijol..."
                class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Categoría</label>
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
                Consultar
            </button>
            <a href="{{ route('vendedor.dashboard') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-slate-600 hover:bg-slate-50 transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- GRID DE PRODUCTOS PARA CAJA -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($productos as $p)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between hover:shadow-md transition">
            <div>
                <div class="flex items-start justify-between gap-2 mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                        {{ $p->categoria->nombre ?? 'General' }}
                    </span>
                    <span class="font-mono text-[10px] text-slate-400">
                        {{ $p->codigo_barras ?? 'S/C' }}
                    </span>
                </div>

                <h3 class="font-bold text-slate-800 text-base leading-tight mb-1">
                    {{ $p->nombre }}
                </h3>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-baseline justify-between mb-2">
                    <span class="text-xs text-slate-400">Precio / {{ $p->unidad_medida }}</span>
                    <span class="text-xl font-black text-[#0F3D2F]">
                        ${{ number_format($p->precio, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs pt-2 border-t border-dashed border-slate-100">
                    <span class="text-slate-500 font-medium">Disponible:</span>
                    <span class="font-black {{ $p->estaAgotado() ? 'text-rose-600' : ($p->estaEnStockBajo() ? 'text-amber-600' : 'text-emerald-700') }}">
                        @if($p->estaAgotado())
                            AGOTADO (0)
                        @else
                            {{ number_format($p->stock_total, 2) }} {{ $p->unidad_medida }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-100">
            <p class="text-slate-400 text-sm">No se encontraron productos en el inventario con los criterios de búsqueda.</p>
        </div>
    @endforelse
</div>

@if($productos->hasPages())
    <div class="mt-8">
        {{ $productos->links() }}
    </div>
@endif

@endsection
