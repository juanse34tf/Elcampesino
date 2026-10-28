<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'El Campesino - Minimarket')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- NAVBAR BASE -->
    <header class="bg-emerald-800 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- LOGO / NOMBRE -->
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <span class="text-2xl">🥩</span>
                        <div>
                            <span class="font-bold text-lg tracking-tight block">El Campesino</span>
                            <span class="text-xs text-emerald-200 block -mt-1">Carnes • Pollos • Víveres</span>
                        </div>
                    </a>
                </div>

                <!-- NAVEGACIÓN PRINCIPAL -->
                <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    <a href="{{ url('/') }}" class="hover:text-emerald-200 transition">Catálogo</a>
                    <a href="{{ url('/inventario') }}" class="hover:text-emerald-200 transition">Inventario & Lotes</a>
                    <a href="{{ url('/pedidos') }}" class="hover:text-emerald-200 transition">Recepción Pedidos</a>
                    <a href="{{ url('/despacho') }}" class="hover:text-emerald-200 transition">Repartidores</a>
                </nav>

                <!-- ACCIONES RÁPIDAS (Carrito / Login) -->
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 bg-emerald-700 hover:bg-emerald-600 rounded-full text-white transition" title="Carrito">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-amber-500 text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
                    </button>
                    <a href="{{ url('/login') }}" class="bg-amber-500 hover:bg-amber-600 text-stone-900 font-semibold px-4 py-2 rounded-lg text-sm transition">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-stone-900 text-stone-400 py-6 border-t border-stone-800 text-center text-sm">
        <p>Tienda El Campesino &copy; {{ date('Y') }} — Seminario Integrador 2026-02</p>
    </footer>

</body>
</html>
