@extends('layouts.app')

@section('contenido')

<div class="mb-8">
    <h1 class="text-3xl font-black text-[#0F3D2F]">
        Centro de Alertas de Inventario
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Monitoreo automatizado de reposición de stock y caducidad de lotes
    </p>
</div>

<!-- KPI CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">

    <!-- Stock Bajo -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-amber-800 text-sm">Stock por Debajo del Mínimo</h3>
            <span class="text-xl">⚠️</span>
        </div>
        <p class="text-4xl font-black text-amber-700 mt-3">
            {{ $productosStockBajo->count() }}
        </p>
        <p class="text-xs text-amber-600 mt-1">Requieren orden de compra urgente</p>
    </div>

    <!-- Agotados -->
    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-rose-800 text-sm">Productos Agotados (0)</h3>
            <span class="text-xl">🛑</span>
        </div>
        <p class="text-4xl font-black text-rose-700 mt-3">
            {{ $productosAgotados->count() }}
        </p>
        <p class="text-xs text-rose-600 mt-1">Sin existencia en bodega</p>
    </div>

    <!-- Lotes por Vencer -->
    <div class="bg-purple-50 border border-purple-200 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-purple-800 text-sm">Lotes en Riesgo (<= 30 días)</h3>
            <span class="text-xl">⏳</span>
        </div>
        <p class="text-4xl font-black text-purple-700 mt-3">
            {{ $lotesVencidos->count() + $lotesCriticos->count() + $lotesProximos->count() }}
        </p>
        <p class="text-xs text-purple-600 mt-1">
            {{ $lotesCriticos->count() }} críticos (<= 7d) • {{ $lotesVencidos->count() }} vencidos
        </p>
    </div>

</div>

<!-- SECCIÓN 1: CONTROL DE FECHAS DE VENCIMIENTO -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-10 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-[#0F3D2F]">Lotes con Alerta de Vencimiento</h2>
            <p class="text-xs text-slate-500">Priorización de rotación bajo método PEPS (Primeras Entradas, Primeras Salidas)</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
            Módulo 5: Caducidad
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Producto</th>
                    <th class="py-4 px-6">Lote / Proveedor</th>
                    <th class="py-4 px-6 text-center">Stock Afectado</th>
                    <th class="py-4 px-6 text-center">Fecha Límite</th>
                    <th class="py-4 px-6 text-center">Nivel de Riesgo</th>
                    <th class="py-4 px-6">Acción Operativa Sugerida</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @php
                    $todosLotes = $lotesVencidos->concat($lotesCriticos)->concat($lotesProximos);
                @endphp

                @forelse($todosLotes as $lote)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            {{ $lote->producto->nombre ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-mono text-xs font-bold text-slate-700">{{ $lote->numero_lote }}</span>
                            <p class="text-[11px] text-slate-400">{{ $lote->proveedor->nombre ?? 'Sin proveedor' }}</p>
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-slate-800">
                            {{ number_format($lote->stock_actual, 2) }} {{ $lote->producto->unidad_medida ?? '' }}
                        </td>
                        <td class="py-4 px-6 text-center text-xs font-medium text-slate-600">
                            {{ $lote->fecha_vencimiento->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($lote->dias_para_vencer < 0)
                                <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-red-100 text-red-800 animate-pulse">
                                    VENCIDO (hace {{ abs($lote->dias_para_vencer) }}d)
                                </span>
                            @elseif($lote->dias_para_vencer <= 7)
                                <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-rose-100 text-rose-800">
                                    CRÍTICO ({{ $lote->dias_para_vencer }} días)
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-100 text-amber-800">
                                    PRÓXIMO ({{ $lote->dias_para_vencer }} días)
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs font-semibold">
                            @if($lote->dias_para_vencer < 0)
                                <span class="text-red-700">🛑 Descartar inmediatamente / Ajuste Kardex</span>
                            @elseif($lote->dias_para_vencer <= 7)
                                <span class="text-rose-700">⚡ Aplicar descuento relámpago / Rotación prioritaria</span>
                            @else
                                <span class="text-amber-700">📦 Ubicar en primera línea de despacho</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No hay lotes con riesgo de vencimiento en los próximos 30 días.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- SECCIÓN 2: CONTROL DE STOCK MÍNIMO Y AGOTADOS -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-[#0F3D2F]">Productos en Riesgo de Desabastecimiento</h2>
            <p class="text-xs text-slate-500">Alertas activas por quiebre de stock mínimo configurado</p>
        </div>
        <a href="{{ route('admin.entradas.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
            + Generar Entrada de Mercancía →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Producto</th>
                    <th class="py-4 px-6">Categoría</th>
                    <th class="py-4 px-6 text-center">Stock Actual</th>
                    <th class="py-4 px-6 text-center">Stock Mínimo</th>
                    <th class="py-4 px-6 text-center">Déficit</th>
                    <th class="py-4 px-6 text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @php
                    $productosAlerta = $productosStockBajo->concat($productosAgotados);
                @endphp

                @forelse($productosAlerta as $p)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            {{ $p->nombre }}
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-500">
                            {{ $p->categoria->nombre ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-center font-black {{ $p->estaAgotado() ? 'text-rose-600' : 'text-amber-600' }}">
                            {{ number_format($p->stock_total, 2) }} {{ $p->unidad_medida }}
                        </td>
                        <td class="py-4 px-6 text-center text-xs text-slate-500 font-medium">
                            {{ number_format($p->stock_minimo, 2) }} {{ $p->unidad_medida }}
                        </td>
                        <td class="py-4 px-6 text-center text-xs font-bold text-rose-600">
                            -{{ number_format(max(0, $p->stock_minimo - $p->stock_total), 2) }} {{ $p->unidad_medida }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.entradas.index') }}"
                               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-[#0F3D2F] hover:bg-emerald-900 text-white text-xs font-bold transition">
                                <span>Reabastecer</span>
                                <span>+</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            Excelente: todos los productos cuentan con niveles de stock óptimos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
