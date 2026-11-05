@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Entradas de mercancía
        </h1>

        <p class="text-gray-500 mt-2">
            Registro de compras e ingresos al inventario
        </p>

    </div>

    <button
    class="
    bg-[#0F3D2F]
    hover:bg-green-800
    text-white
    px-6
    py-3
    rounded-xl
    ">
        + Registrar Entrada
    </button>

</div>

<div class="bg-white p-6 rounded-2xl shadow">

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="text-left py-4">
                    Fecha y hora
                </th>

                <th class="text-left py-4">
                    Proveedor
                </th>

                <th class="text-left py-4">
                    Productos
                </th>

                <th class="text-left py-4">
                    Accion
                </th>

                <th class="text-left py-4">
                    Total
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
                    Proveedor Demo
                </td>

                <td>
                    5 Productos
                </td>

                    <td>

             <button
                onclick="abrirModal()"
                class="
                bg-blue-100
                text-blue-700
                px-4
                py-2
                rounded-lg
                hover:bg-blue-200">
                👁 Ver detalle
            </button>

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
                        $1.200.000
                    </span>

                </td>

            </tr>

        </tbody>

    </table>

</div>

<div
id="modalDetalle"
class="
hidden
fixed
inset-0
bg-black/50
flex
items-center
justify-center"
>

    <div
    class="
    bg-white
    rounded-2xl
    p-6
    w-[700px]"
    >

        <div
        class="
        flex
        justify-between
        items-center
        mb-6"
        >

            <h2
            class="
            text-2xl
            font-bold
            text-[#0F3D2F]"
            >
                Detalle Entrada #1
            </h2>

            <button
            onclick="cerrarModal()"
            class="
            text-red-500
            font-bold
            text-xl"
            >
                ✕
            </button>

        </div>

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">
                        Producto
                    </th>

                    <th class="text-left py-3">
                        Cantidad
                    </th>

                    <th class="text-left py-3">
                        Precio
                    </th>

                    <th class="text-left py-3">
                        Subtotal
                    </th>

                </tr>

            </thead>

            <tbody>

                <tr class="border-b">

                    <td class="py-3">
                        Leche
                    </td>

                    <td>
                        50
                    </td>

                    <td>
                        $3.000
                    </td>

                    <td>
                        $150.000
                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3">
                        Yogurt
                    </td>

                    <td>
                        20
                    </td>

                    <td>
                        $5.000
                    </td>

                    <td>
                        $100.000
                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3">
                        Queso
                    </td>

                    <td>
                        30
                    </td>

                    <td>
                        $10.000
                    </td>

                    <td>
                        $300.000
                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3">
                        Mantequilla
                    </td>

                    <td>
                        25
                    </td>

                    <td>
                        $8.000
                    </td>

                    <td>
                        $200.000
                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3">
                        Arequipe
                    </td>

                    <td>
                        50
                    </td>

                    <td>
                        $9.000
                    </td>

                    <td>
                        $450.000
                    </td>

                </tr>

                <tr>

                    <td colspan="3"
                        class="
                        text-right
                        font-bold
                        py-4
                        pr-4
                        ">
                        Total General
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
                            $1.200.000
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

<script>

function abrirModal()
{
    document
        .getElementById('modalDetalle')
        .classList
        .remove('hidden');
}

function cerrarModal()
{
    document
        .getElementById('modalDetalle')
        .classList
        .add('hidden');
}

</script>
@endsection