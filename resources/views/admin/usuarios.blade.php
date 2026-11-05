@extends('layouts.app')

@section('contenido')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Usuarios
        </h1>

        <p class="text-gray-500 mt-2">
            Administración de usuarios y permisos
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
        + Nuevo Usuario
    </button>

</div>

<div class="bg-white p-6 rounded-2xl shadow">

    <div class="mb-6">

        <input
            type="text"
            placeholder="Buscar usuario..."
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
                    Correo
                </th>

                <th class="text-left py-4">
                    Rol
                </th>

                <th class="text-left py-4">
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b">

                <td class="py-4">
                    Administrador Sistema
                </td>

                <td>
                    admin@campesino.com
                </td>

                <td>
                    Administrador
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
                        Activo
                    </span>

                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection