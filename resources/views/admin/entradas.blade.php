@extends('layouts.app')

@section('contenido')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-[#0F3D2F]">
            Entradas de Mercancía
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Recepción de compras, asignación de lotes y fechas de vencimiento
        </p>
    </div>

    <button onclick="document.getElementById('modalRegistrarEntrada').classList.remove('hidden')"
            class="bg-[#0F3D2F] hover:bg-emerald-900 text-white font-bold px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 text-sm">
        <span>+</span>
        <span>Registrar Nueva Entrada</span>
    </button>
</div>

<!-- TABLA DE ENTRADAS RECIENTES (LOTES REGISTRADOS) -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-[#0F3D2F]">Historial de Lotes Ingresados</h2>
        <span class="text-xs text-slate-500">Últimos registros auditados en Kardex</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                    <th class="py-4 px-6">Fecha Ingreso</th>
                    <th class="py-4 px-6">Lote #</th>
                    <th class="py-4 px-6">Producto</th>
                    <th class="py-4 px-6">Proveedor</th>
                    <th class="py-4 px-6 text-center">Stock Actual</th>
                    <th class="py-4 px-6 text-right">Costo Compra</th>
                    <th class="py-4 px-6 text-center">Vencimiento</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($entradasRecientes as $entrada)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-xs text-slate-600 font-medium">
                            {{ $entrada->fecha_ingreso->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-6 font-mono text-xs font-bold text-slate-700">
                            {{ $entrada->numero_lote }}
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $entrada->producto->nombre ?? 'N/A' }}</p>
                            <span class="text-[11px] text-slate-400">Unidad: {{ $entrada->producto->unidad_medida ?? 'KG' }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-600 text-xs font-medium">
                            {{ $entrada->proveedor->nombre ?? 'Proveedor no asignado' }}
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-slate-800">
                            {{ number_format($entrada->stock_actual, 2) }} {{ $entrada->producto->unidad_medida ?? '' }}
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-slate-800">
                            ${{ number_format($entrada->costo_compra, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg
                                {{ $entrada->dias_para_vencer <= 7 ? 'bg-rose-100 text-rose-800' : ($entrada->dias_para_vencer <= 30 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                {{ $entrada->fecha_vencimiento->format('d/m/Y') }}
                                ({{ $entrada->dias_para_vencer }}d)
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            No se registran entradas de mercancía en el sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL REGISTRAR ENTRADA -->
<div id="modalRegistrarEntrada" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-[#0F3D2F]">Registrar Entrada de Mercancía</h3>
                <p class="text-xs text-slate-400">Actualiza existencias y genera registro en Kardex automáticamente</p>
            </div>
            <button onclick="document.getElementById('modalRegistrarEntrada').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.entradas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Producto a Ingresar *</label>
                    <select name="producto_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="">-- Seleccionar Producto --</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id }}">
                                {{ $prod->nombre }} ({{ $prod->unidad_medida }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Proveedor de Origen</label>
                    <select name="proveedor_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                        <option value="">-- Seleccionar Proveedor --</option>
                        @foreach($proveedores as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Número de Lote *</label>
                    <input type="text" name="numero_lote" required placeholder="LOT-2026-..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Cantidad Recibida *</label>
                    <input type="number" step="0.01" name="cantidad" required placeholder="Ej. 25.5" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Costo Unit. Compra *</label>
                    <input type="number" step="0.01" name="costo_compra" required placeholder="$$" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Fecha de Ingreso *</label>
                    <input type="date" name="fecha_ingreso" required value="{{ date('Y-m-d') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Fecha de Vencimiento *</label>
                    <input type="date" name="fecha_vencimiento" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0F3D2F] focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modalRegistrarEntrada').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 bg-[#0F3D2F] text-white rounded-xl text-sm font-bold hover:bg-emerald-900 shadow">
                    Confirmar Entrada
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
