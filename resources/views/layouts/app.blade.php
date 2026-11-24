<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css'])

    <title>{{ $titulo ?? 'El Campesino - MiniMarket' }}</title>
</head>

<body class="bg-[#F3F2EC] text-slate-800 antialiased min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F3D2F] text-white p-6 flex flex-col justify-between shrink-0 shadow-lg">

        <div>
            <!-- LOGO / BRAND -->
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-xl font-bold shadow-md">
                    🥩
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white">El Campesino</h1>
                    <p class="text-xs text-emerald-300 font-medium tracking-wide">MiniMarket & Logística</p>
                </div>
            </div>

            <!-- NAVIGATION -->
            <nav class="space-y-2">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.dashboard')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">📊</span>
                        <span>Resumen General</span>
                    </a>

                    <a href="{{ route('admin.inventario.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.inventario.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">📦</span>
                        <span>Inventario</span>
                    </a>

                    <a href="{{ route('admin.entradas.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.entradas.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">🚚</span>
                        <span>Entradas de Mercancía</span>
                    </a>

                    <a href="{{ route('admin.movimientos.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.movimientos.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">🔄</span>
                        <span>Kardex y Movimientos</span>
                    </a>

                    <a href="{{ route('admin.alertas.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.alertas.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">⚠️</span>
                        <span>Alertas y Vencimientos</span>
                    </a>

                    <a href="{{ route('admin.proveedores.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.proveedores.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">🏢</span>
                        <span>Proveedores</span>
                    </a>

                    <a href="{{ route('admin.usuarios.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('admin.usuarios.*')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">
                        <span class="text-lg">👥</span>
                        <span>Usuarios del Sistema</span>
                    </a>

                    <div class="pt-4 border-t border-emerald-800/60 my-2"></div>
                @endif

                <a href="{{ route('vendedor.dashboard') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('vendedor.*')
                       ? 'bg-amber-600 text-white shadow-md'
                       : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                   }}">
                    <span class="text-lg">🛒</span>
                    <span>Punto de Venta / Caja</span>
                </a>
            </nav>
        </div>

        <!-- FOOTER / USER PROFILE & LOGOUT -->
        <div class="pt-6 border-t border-emerald-800/80">
            @auth
                <div class="flex items-center justify-between mb-4">
                    <div class="overflow-hidden pr-2">
                        <p class="text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
                        <span class="inline-block mt-0.5 px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-700 text-amber-300">
                            {{ Auth::user()->rol }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center space-x-2 px-3 py-2.5 rounded-xl bg-red-600/20 text-red-200 hover:bg-red-600 hover:text-white transition-all text-sm font-medium">
                        <span>🚪</span>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center text-sm font-medium text-amber-300 hover:underline">
                    Iniciar Sesión
                </a>
            @endauth
        </div>

    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 p-8 overflow-y-auto max-w-7xl mx-auto w-full">

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center space-x-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm">
                <div class="flex items-center space-x-2 font-semibold text-sm mb-1 text-rose-800">
                    <span>⚠️</span>
                    <span>Por favor corrige los siguientes errores:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('contenido')

    </main>

</div>

</body>
</html>
