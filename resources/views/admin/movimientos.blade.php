@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Movimientos
        </h1>

        <p class="text-gray-500 mt-2">
            Historial de entradas y salidas del inventario
        </p>

    </div>

</div>

<div class="bg-white p-6 rounded-2xl shadow">

    <div class="mb-6">

        <input
            type="text"
            placeholder="Buscar movimiento..."
            class="w-full border rounded-lg p-3"
        >

    </div>

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="text-left py-4">
                    Fecha y hora
                </th>

                <th class="text-left py-4">
                    Producto
                </th>

                <th class="text-left py-4">
                    Tipo
                </th>

                <th class="text-left py-4">
                    Cantidad
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b">

                <td class="py-4">
                    <div>
                        02/11/2026
                    </div>

                    <div class="text-gray-500 text-sm">
                        09:15 AM
                    </div>
                </td>

                <td>
                    Leche
                </td>

                <td>

                    <span
                    class="
                    bg-green-100
                    text-green-700
                    font-semibold
                    px-3
                    py-1
                    rounded-full
                    ">
                        Entrada
                    </span>

                </td>

                <td>
                    50
                </td>

            </tr>

            <tr>

                <td class="py-4">
                    <div>
                        02/11/2026
                    </div>

                    <div class="text-gray-500 text-sm">
                        08:15 AM
                    </div>
                </td>

                <td>
                    Leche
                </td>

                <td>

                    <span
                    class="
                    bg-red-100
                    text-red-700
                    font-semibold
                    px-3
                    py-1
                    rounded-full
                    ">
                        Salida
                    </span>

                </td>

                <td>
                    10
                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection