@extends('layouts.app')

@section('contenido')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-[#0F3D2F]">
        Resumen
    </h1>

    <p class="text-gray-500 mt-2">
        Bienvenido al panel administrativo
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow">

        <h3 class="text-gray-500 font-semibold">
            Productos
        </h3>

        <p class="text-5xl font-bold text-[#0F3D2F] mt-4">
            125
        </p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow">

        <h3 class="text-gray-500 font-semibold">
            Proveedores
        </h3>

        <p class="text-5xl font-bold text-[#0F3D2F] mt-4">
            12
        </p>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow">

        <h3 class="text-gray-500 font-semibold">
            Alertas
        </h3>

        <p class="text-5xl font-bold text-red-500 mt-4">
            2
        </p>

    </div>

</div>

<div class="mt-10">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow">

            <h2
            class="text-2xl font-bold text-[#0F3D2F] mb-6">
                Últimos movimientos
            </h2>

            <div class="space-y-6">

                <div>

                    <p class="font-semibold">
                        🚚 Entrada registrada
                    </p>

                    <p class="text-sm text-gray-500">
                        02/11/2026 • 09:15 AM
                    </p>

                    <p>
                        Proveedor: Alpina
                    </p>

                    <p>
                        Valor: $1.200.000
                    </p>

                </div>

                <div>

                    <p class="font-semibold">
                        📦 Producto agregado
                    </p>

                    <p class="text-sm text-gray-500">
                        02/11/2026 • 10:25 AM
                    </p>

                    <p>
                        Leche Entera
                    </p>

                </div>

                <div>

                    <p class="font-semibold">
                        ⚠ Stock bajo
                    </p>

                    <p class="text-sm text-gray-500">
                        02/11/2026 • 11:40 AM
                    </p>

                    <p>
                        Yogurt Fresa
                    </p>

                </div>

                <div>

                    <p class="font-semibold">
                        🔄 Movimiento registrado
                    </p>

                    <p class="text-sm text-gray-500">
                        02/11/2026 • 02:15 PM
                    </p>

                    <p>
                        Salida de 10 unidades de Leche
                    </p>

                </div>

            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow">

            <h2
            class="text-2xl font-bold text-[#0F3D2F] mb-6">
                Estado del Inventario
            </h2>

            <div class="space-y-5">

                <div
                class="flex justify-between items-center">

                    <span>
                        Productos disponibles
                    </span>

                    <span
                    class="
                    bg-green-100
                    text-green-700
                    px-3
                    py-1
                    rounded-full
                    font-semibold
                    ">
                        120
                    </span>

                </div>

                <div
                class="flex justify-between items-center">

                    <span>
                        Stock bajo
                    </span>

                    <span
                    class="
                    bg-yellow-100
                    text-yellow-700
                    px-3
                    py-1
                    rounded-full
                    font-semibold
                    ">
                        3
                    </span>

                </div>

                <div
                class="flex justify-between items-center">

                    <span>
                        Agotados
                    </span>

                    <span
                    class="
                    bg-red-100
                    text-red-700
                    px-3
                    py-1
                    rounded-full
                    font-semibold
                    ">
                        2
                    </span>

                </div>

            </div>

            <div class="mt-8 border-t pt-6">

                <h3
                class="font-bold text-[#0F3D2F] mb-4">
                    Productos críticos
                </h3>

                <ul class="space-y-3">

                    <li class="flex justify-between">

                        <span>
                            Yogurt Fresa
                        </span>

                        <span class="text-red-600 font-bold">
                            0 unidades
                        </span>

                    </li>

                    <li class="flex justify-between">

                        <span>
                            Leche Entera
                        </span>

                        <span class="text-yellow-600 font-bold">
                            3 unidades
                        </span>

                    </li>

                    <li class="flex justify-between">

                        <span>
                            Mantequilla
                        </span>

                        <span class="text-yellow-600 font-bold">
                            4 unidades
                        </span>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

@endsection