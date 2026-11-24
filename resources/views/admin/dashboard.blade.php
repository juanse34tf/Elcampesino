@extends('layouts.app')

@section('contenido')

<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Resumen General
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Panel de control operativo e inventarios • El Campesino MiniMarket
        </p>
    </div>

    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.entradas.index') }}"
           class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-[#0F3D2F] hover:bg-emerald-900 text-white text-sm font-semibold shadow transition">
            <span>+</span>
            <span>Nueva Entrada</span>
        </a>
        <a href="{{ route('admin.alertas.index') }}"
           class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow transition">
            <span>⚠️</span>
            <span>Ver Alertas ({{ $lotesCriticosCount + $productosStockBajo->count() }})</span>
        </a>
    </div>
</div>

<!-- KPI CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <!-- Total Productos -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Catálogo Activo</span>
            <span class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0F3D2F] flex items-center justify-center text-lg">📦</span>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-black text-[#0F3D2F]">{{ $totalProductos }}</p>
            <p class="text-xs text-slate-500 mt-1">Productos registrados</p>
        </div>
    </div>

    <!-- Proveedores -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Proveedores</span>
            <span class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg">🏢</span>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-black text-slate-800">{{ $totalProveedores }}</p>
            <p class="text-xs text-slate-500 mt-1">Aliados comerciales activos</p>
        </div>
    </div>

    <!-- Alertas Críticas -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Atención Requerida</span>
            <span class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg">⚠️</span>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-black text-rose-600">{{ $lotesCriticosCount + $productosStockBajo->count() }}</p>
            <p class="text-xs text-rose-500 font-medium mt-1">
                {{ $lotesCriticosCount }} lotes por vencer • {{ $productosStockBajo->count() }} stock bajo
            </p>
        </div>
    </div>

    <!-- Valorización del inventario -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Valor en Inventario</span>
            <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">💰</span>
        </div>
        <div class="mt-4">
            <p class="text-2xl font-black text-slate-800">
                ${{ number_format($valorTotalInventario, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-500 mt-1">Costo total de lotes en bodega</p>
        </div>
    </div>

</div>

<!-- DETALLE GRID: MOVIMIENTOS RECIENTES Y LOTES POR VENCER -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- ÚLTIMOS MOVIMIENTOS DE KARDEX -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-[#0F3D2F]">
                Últimos Movimientos (Kardex)
            </h2>
            <a href="{{ route('admin.movimientos.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
                Ver todos →
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($movimientosRecientes as $mov)
                <div class="py-3.5 flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <span class="text-lg mt-0.5">
                            @if($mov->tipo === 'ENTRADA') 📥
                            @elseif($mov->tipo === 'SALIDA') 📤
                            @else 🔄
                            @endif
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $mov->producto->nombre ?? 'Producto' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $mov->motivo }}
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                {{ $mov->created_at->format('d/m/Y h:i A') }} • Responsable: {{ $mov->usuario->name ?? 'Sistema' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2.5 py-1 text-xs font-black rounded-lg
                            {{ $mov->tipo === 'ENTRADA' ? 'bg-emerald-100 text-emerald-800' : ($mov->tipo === 'SALIDA' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $mov->tipo === 'ENTRADA' ? '+' : ($mov->tipo === 'SALIDA' ? '-' : '±') }}{{ number_format($mov->cantidad, 2) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 py-6 text-center">No hay movimientos registrados recientemente.</p>
            @endforelse
        </div>
    </div>

    <!-- LOTES EN SEGUIMIENTO Y CATEGORÍAS -->
    <div class="space-y-8">

        <!-- Lotes Próximos a Vencer -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-[#0F3D2F]">
                    Lotes Próximos a Vencer (30 Días)
                </h2>
                <a href="{{ route('admin.alertas.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700">
                    Ir al panel de alertas →
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($lotesPorVencer->take(5) as $lote)
                    <div class="py-3 flex items-center justify-between text-sm">
                        <div>
                            <p class="font-bold text-slate-800">{{ $lote->producto->nombre ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">Lote: {{ $lote->numero_lote }} • Stock: {{ number_format($lote->stock_actual, 2) }} {{ $lote->producto->unidad_medida ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2.5 py-1 text-xs font-bold rounded-lg
                                {{ $lote->dias_para_vencer <= 7 ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800' }}">
                                @if($lote->dias_para_vencer < 0)
                                    Vencido hace {{ abs($lote->dias_para_vencer) }} días
                                @elseif($lote->dias_para_vencer == 0)
                                    Vence hoy
                                @else
                                    Vence en {{ $lote->dias_para_vencer }} días
                                @endif
                            </span>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $lote->fecha_vencimiento->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 py-4 text-center">No hay lotes con riesgo de vencimiento cercano.</p>
                @endforelse
            </div>
        </div>

        <!-- Distribución por Categorías -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-[#0F3D2F] mb-4">
                Categorías de la Tienda
            </h2>
            <div class="grid grid-cols-2 gap-3">
                @foreach($categorias as $cat)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-xs text-slate-800">{{ $cat->nombre }}</p>
                            <p class="text-[11px] text-slate-500">{{ $cat->productos_count }} productos</p>
                        </div>
                        <span class="text-sm text-amber-600 font-bold">📦</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

@endsection
