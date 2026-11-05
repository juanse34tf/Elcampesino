@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Proveedores
        </h1>

        <p class="text-gray-500 mt-2">
            Gestión de proveedores
        </p>

    </div>

    <button
        class="bg-[#0F3D2F]
               hover:bg-green-800
               text-white
               px-6
               py-3
               rounded-xl"
    >
        + Nuevo Proveedor
    </button>

</div>

<div class="bg-white p-6 rounded-2xl shadow">

    <div class="mb-6">

        <input
            type="text"
            placeholder="Buscar proveedor..."
            class="w-full border rounded-lg p-3"
        >

    </div>

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="text-left py-4">
                    Nombre
                </th>

                <th class="text-left py-4">
                    Teléfono
                </th>

                <th class="text-left py-4">
                    Ciudad
                </th>

                <th class="text-left py-4">
                    Compras del mes
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b">

                <td class="py-4">
                    Proveedor Demo
                </td>

                <td>
                    3000000000
                </td>

                <td>
                    Cali
                </td>

                <td>

                   <span
                        class="bg-green-100
                        text-green-700
                        font-semibold
                        px-3
                        py-1
                        rounded-full">
                        $1.200.000
                    </span>
                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection