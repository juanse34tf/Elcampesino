<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css'])

    <title>El Campesino</title>
</head>

<body class="bg-[#F3F2EC]">

<div class="flex min-h-screen">

    <aside
        class="w-64 bg-[#0F3D2F] text-white p-6"
    >

        <h1 class="text-2xl font-bold mb-10">
            El Campesino
        </h1>

<nav class="space-y-4">

    <a href="/admin/dashboard"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/dashboard')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        📊 Resumen
    </a>

    <a href="/admin/inventario"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/inventario')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        📦 Inventario
    </a>

    <a href="/admin/entradas"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/entradas')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        🚚 Entradas de mercancía
    </a>

    <a href="/admin/movimientos"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/movimientos')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        🔄 Movimientos
    </a>

    <a href="/admin/alertas"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/alertas')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        ⚠ Alertas
    </a>

    <a href="/admin/proveedores"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/proveedores')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        🏢 Proveedores
    </a>

    <a href="/admin/usuarios"
       class="block p-3 rounded-lg transition

       {{ request()->is('admin/usuarios')
           ? 'bg-amber-600 text-white'
           : 'hover:bg-green-700'
       }}">
        👥 Usuarios
    </a>

</nav>

    </aside>

    <main class="flex-1 p-8">

        @yield('contenido')

    </main>

</div>

</body>

</html>