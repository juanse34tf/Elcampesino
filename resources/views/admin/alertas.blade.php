@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Alertas
        </h1>

        <p class="text-gray-500 mt-2">
            Productos con stock crítico o agotado
        </p>

    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">

        <h3 class="font-semibold text-yellow-700">
            Stock Bajo
        </h3>

        <p class="text-4xl font-bold text-yellow-700 mt-3">
            3
        </p>

    </div>

    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

        <h3 class="font-semibold text-red-700">
            Agotados
        </h3>

        <p class="text-4xl font-bold text-red-700 mt-3">
            2
        </p>

    </div>

    <div class="bg-green-50 border border-green-200 rounded-2xl p-6">

        <h3 class="font-semibold text-green-700">
            Sin Alertas
        </h3>

        <p class="text-4xl font-bold text-green-700 mt-3">
            45
        </p>

    </div>

</div>

<div class="bg-white p-6 rounded-2xl shadow">

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="text-left py-4">
                    Producto
                </th>

                <th class="text-left py-4">
                    Stock Actual
                </th>

                <th class="text-left py-4">
                    Stock Mínimo
                </th>

                <th class="text-left py-4">
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b">

                <td class="py-4">
                    Leche Entera
                </td>

                <td>
                    3
                </td>

                <td>
                    10
                </td>

                <td>

                    <span
                    class="
                    bg-yellow-100
                    text-yellow-700
                    font-semibold
                    px-3
                    py-1
                    rounded-full
                    ">
                        Stock Bajo
                    </span>

                </td>

            </tr>

            <tr>

                <td class="py-4">
                    Yogurt Fresa
                </td>

                <td>
                    0
                </td>

                <td>
                    10
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
                        Agotado
                    </span>

                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection