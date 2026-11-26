<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>El Campesino</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-stone-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->

    <aside
        class="
        w-72
        bg-gradient-to-b
        from-[#0F3D2F]
        to-[#083827]
        text-white
        p-6
        flex
        flex-col
        ">

        <!-- LOGO -->

        <div class="mb-10">

            <h1 class="text-3xl font-black">
                El Campesino
            </h1>

            <p class="text-green-300 font-medium">
                MiniMarket & Logística
            </p>

        </div>

        <!-- MENU -->

        <nav class="space-y-3">

            <a href="{{ route('vendedor.dashboard') }}"
               class="
                    flex       
                    items-center
                    gap-3
                    px-5
                    py-4
                    rounded-2xl
                    font-bold
                    transition

                    {{ request()->routeIs('vendedor.dashboard')
                        ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                    }}
                    ">

                🛒 Punto de Venta / Caja

            </a>

            <a href="{{ route('vendedor.movimientos') }}"
              class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('vendedor.movimientos')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">

                📋 Movimientos

            </a>

            <a href="{{ route('vendedor.alertas') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                       {{ request()->routeIs('vendedor.alertas')
                           ? 'bg-amber-600 text-white shadow-md'
                           : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white'
                       }}">

                ⚠ Alertas

            </a>

        </nav>

        <!-- FOOTER -->

        <div class="mt-auto pt-8 border-t border-white/10">

            <p class="font-bold">
                {{ Auth::user()->name ?? 'Empleado' }}
            </p>

            <span
                class="
                inline-block
                mt-2
                bg-green-500
                text-white
                text-xs
                px-3
                py-1
                rounded-full
                font-bold">

                EMPLEADO

            </span>

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="mt-4">

                @csrf

                <button
                    type="submit"
                    class="
                    w-full
                    bg-white/10
                    hover:bg-white/20
                    py-3
                    rounded-xl
                    font-semibold">

                    Cerrar sesión

                </button>

            </form>

        </div>

    </aside>

    <!-- CONTENIDO -->

    <main class="flex-1 p-8">

        @yield('contenido')

    </main>

</div>

</body>

</html>