<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css'])

    <title>Administrador</title>
</head>

<body class="bg-[#F3F2EC]">

<div class="flex min-h-screen">

    <!-- Sidebar -->

    <aside class="w-64 bg-[#0F3D2F] text-white p-6">

        <h1 class="text-2xl font-bold mb-10">
            El Campesino
        </h1>

        <nav class="space-y-4">

            <a href="/admin/dashboard" class="block p-3 rounded-lg bg-yellow-600">
                📊 Resumen
            </a>

            <a href="/admin/inventario" class="block p-3 rounded-lg hover:bg-green-700">
                📦 Inventario
            </a>

            <a href="/admin/entradas" class="block p-3 rounded-lg hover:bg-green-700">
                🚚 Entradas de mercancía
            </a>

            <a href="/admin/movimientos" class="block p-3 rounded-lg hover:bg-green-700">
                🔄 Movimientos
            </a>

            <a href="/admin/alertas" class="block p-3 rounded-lg hover:bg-green-700">
                ⚠ Alertas
            </a>

            <a href="/admin/proveedores" class="block p-3 rounded-lg hover:bg-green-700">
                🏢 Proveedores
            </a>

            <a href="/admin/usuarios" class="block p-3 rounded-lg hover:bg-green-700">
                👥 Usuarios
            </a>

        </nav>

    </aside>

    <!-- Contenido -->

    <main class="flex-1 p-8">

        <h1 class="text-4xl font-bold text-[#0F3D2F]">
            Resumen
        </h1>

        <div class="grid grid-cols-3 gap-6 mt-8">

            <div class="bg-white p-6 rounded-xl shadow">
                Productos
                <p class="text-3xl mt-2">0</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                Proveedores
                <p class="text-3xl mt-2">0</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                Alertas
                <p class="text-3xl mt-2">0</p>
            </div>

        </div>

    </main>

</div>

</body>
</html>