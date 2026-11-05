@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Inventario
        </h1>

        <p class="text-gray-500 mt-2">
            Gestión de productos
        </p>

    </div>

    <button
        class="bg-[#0F3D2F]
               hover:bg-green-600
               text-white
               px-6
               py-3
               rounded-xl"
    >
        + Nuevo Producto
    </button>

</div>

<div
    class="bg-white p-6 rounded-2xl shadow"
>

    <div class="mb-6">

        <input
            type="text"
            placeholder="Buscar producto..."
            class="w-full border rounded-lg p-3"
        >

    </div>

    <table
        class="w-full"
    >

        <thead>

            <tr
                class="border-b"
            >

                <th class="text-left py-4">
                    Código
                </th>

                <th class="text-left py-4">
                    Producto
                </th>

                <th class="text-left py-4">
                    Stock
                </th>

                <th class="text-left py-4">
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b">

                <td class="py-4">
                    001
                </td>

                <td>
                    Producto Demo
                </td>

                <td>
                    10
                </td>

                <td>

                    <span
                        class="bg-green-100
                               text-green-600
                               px-3
                               py-1
                               rounded-full"
                    >
                        Disponible
                    </span>

                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection