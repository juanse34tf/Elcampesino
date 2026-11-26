@extends('layouts.vendedor')

@section('contenido')

<div class="mb-8">

    <h1 class="text-4xl font-black text-[#0F3D2F]">
        Movimientos
    </h1>

    <p class="text-slate-500 mt-2">
        Historial de movimientos registrados desde caja
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-2xl p-6 shadow">

        <p class="text-sm text-slate-500">
            Ventas Hoy
        </p>

        <p class="text-4xl font-black text-rose-600 mt-2">
            18
        </p>

    </div>

    <div class="bg-white rounded-2xl p-6 shadow">

        <p class="text-sm text-slate-500">
            Devoluciones Hoy
        </p>

        <p class="text-4xl font-black text-emerald-600 mt-2">
            2
        </p>

    </div>

    <div class="bg-white rounded-2xl p-6 shadow">

        <p class="text-sm text-slate-500">
            Movimientos Totales
        </p>

        <p class="text-4xl font-black text-[#0F3D2F] mt-2">
            20
        </p>

    </div>

</div>

<div class="bg-white rounded-2xl p-6 shadow mb-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <input
            type="text"
            placeholder="Buscar producto..."
            class="border rounded-xl p-3">

        <select
            class="border rounded-xl p-3">

            <option>Todos</option>
            <option>Venta</option>
            <option>Devolución</option>

        </select>

        <input
            type="date"
            class="border rounded-xl p-3">

    </div>

</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-50">

            <tr>

                <th class="py-4 px-4 text-left">
                    Fecha y Hora
                </th>

                <th class="py-4 px-4 text-left">
                    Producto
                </th>

                <th class="py-4 px-4 text-center">
                    Tipo
                </th>

                <th class="py-4 px-4 text-center">
                    Cantidad
                </th>

                <th class="py-4 px-4 text-center">
                    Usuario
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-t">

                <td class="py-4 px-4">
                    25/11/2026 09:25 AM
                </td>

                <td class="px-4">
                    Pechuga de Pollo Campesino
                </td>

                <td class="text-center">

                    <span class="
                    bg-rose-100
                    text-rose-700
                    px-3
                    py-1
                    rounded-full
                    text-xs
                    font-bold">

                        Venta

                    </span>

                </td>

                <td class="text-center font-bold text-rose-600">
                    -2 KG
                </td>

                <td class="text-center">
                    Cajero Principal
                </td>

            </tr>

            <tr class="border-t">

                <td class="py-4 px-4">
                    25/11/2026 11:18 AM
                </td>

                <td class="px-4">
                    Queso Campesino Artesanal
                </td>

                <td class="text-center">

                    <span class="
                    bg-emerald-100
                    text-emerald-700
                    px-3
                    py-1
                    rounded-full
                    text-xs
                    font-bold">

                        Devolución

                    </span>

                </td>

                <td class="text-center font-bold text-emerald-600">
                    +1 LB
                </td>

                <td class="text-center">
                    Cajero Principal
                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection