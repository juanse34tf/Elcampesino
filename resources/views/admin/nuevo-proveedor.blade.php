@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Nuevo proveedor
        </h1>

        <p class="text-gray-500 mt-2">
            Agrega un contacto de abastecimiento para el minimarket.
        </p>

    </div>

    <div class="flex gap-3">

        <a href="/admin/proveedores"
           class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-xl">
            Cancelar
        </a>

        <button
            class="bg-[#0F3D2F] hover:bg-green-800 text-white px-6 py-3 rounded-xl">
            ✓ Guardar proveedor
        </button>

    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <!-- FORMULARIO -->

<div class="lg:col-span-3 space-y-6">

        <!-- INFORMACIÓN -->

        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-xl font-bold text-[#0F3D2F] mb-6">
                Información del proveedor
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-2 font-medium">
                        Nombre / Razón social
                    </label>

                    <input
                        type="text"
                        placeholder="Suministros La Huerta S.A.S."
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Código automático
                    </label>

                    <input
                        type="text"
                        value="PRO-006"
                        readonly
                        class="w-full border rounded-lg p-3 bg-gray-100">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Tipo de identificación
                    </label>

                    <select
                        class="w-full border rounded-lg p-3">

                        <option>NIT</option>
                        <option>CC</option>
                        <option>CE</option>

                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Identificación / NIT
                    </label>

                    <input
                        type="text"
                        placeholder="901.456.782-3"
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Persona de contacto
                    </label>

<input
                        type="text"
                        placeholder="Daniela Torres"
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        placeholder="301 555 0246"
                        class="w-full border rounded-lg p-3">
                </div>

            </div>

            <div class="mt-4">

                <label class="block mb-2 font-medium">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    placeholder="pedidos@suministroslahuerta.com"
                    class="w-full border rounded-lg p-3">

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                <div>

                    <label class="block mb-2 font-medium">
                        Dirección
                    </label>

                    <input
                        type="text"
                        placeholder="Carrera 8 #34-20"
                        class="w-full border rounded-lg p-3">

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Ciudad
                    </label>

                    <input
                        type="text"
                        placeholder="Cali, Valle del Cauca"
                        class="w-full border rounded-lg p-3">

                </div>

            </div>

        </div>

        <!-- ABASTECIMIENTO -->

        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-xl font-bold text-[#0F3D2F] mb-6">
                Abastecimiento y estado
            </h2>

            <label class="block mb-4 font-medium">
                Categorías suministradas
            </label>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                <label class="border rounded-xl p-3">
                    <input type="checkbox" checked>
                    Abarrotes
                </label>

                <label class="border rounded-xl p-3">
                    <input type="checkbox" checked>
                    Bebidas
                </label>

                <label class="border rounded-xl p-3">
                    <input type="checkbox">
                    Lácteos
                </label>

                <label class="border rounded-xl p-3">
                    <input type="checkbox">
                    Aseo
                </label>

                <label class="border rounded-xl p-3">
                    <input type="checkbox">
                    Carnes
                </label>

            </div>

            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Productos suministrados
                </label>

                <textarea
                    rows="4"
                    class="w-full border rounded-lg p-3"
                    placeholder="Arroz 2kg, aceite vegetal, agua mineral..."></textarea>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

                <div>

                    <label class="block mb-2 font-medium">
                        Estado
                    </label>

                    <select
                        class="w-full border rounded-lg p-3">

                        <option>Activo</option>
                        <option>Inactivo</option>

                    </select>

                </div>

                <div>

                    <label class="block mb-2 font-medium">
                        Observaciones
                    </label>

                    <input
                        type="text"
                        placeholder="Recepción: lunes a sábado"
                        class="w-full border rounded-lg p-3">

                </div>

            </div>

        </div>

    </div>

    <!-- PANEL DERECHO -->

    <div class="space-y-6">

        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="font-bold text-[#0F3D2F] mb-4">
                Nuevo contacto
            </h3>

            <p class="text-gray-500 text-sm">
                PRO-006 · Sin guardar
            </p>

            <div class="mt-4">

                <h4 class="font-semibold">
                    Suministros La Huerta
                </h4>

                <p class="text-gray-500 text-sm">
                    Abarrotes y bebidas · Cali
                </p>

            </div>

        </div>

        <div class="bg-green-50 rounded-2xl p-6">

            <h3 class="font-bold text-green-700 mb-3">
                Solo administración
            </h3>

            <p class="text-sm text-green-700">
                Los proveedores y las compras solo pueden ser gestionados por administradores.
            </p>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="font-bold text-[#0F3D2F] mb-4">
                Antes de guardar
            </h3>

            <ul class="space-y-2 text-sm text-gray-500">

                <li>• Verifica NIT y contacto.</li>
                <li>• Evita proveedores duplicados.</li>
                <li>• Este registro no genera compras.</li>

            </ul>

        </div>

    </div>

</div>

@endsection
