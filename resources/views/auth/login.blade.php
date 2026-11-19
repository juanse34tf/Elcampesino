<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - El Campesino</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#F3F2EC] flex items-center justify-center min-h-screen p-4">

    <div class="bg-white shadow-2xl rounded-3xl p-8 md:p-10 w-full max-w-md border border-emerald-100">

        <!-- LOGO & HEADER -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-[#0F3D2F] text-amber-400 flex items-center justify-center text-3xl shadow-lg">
                🥩
            </div>
            <h1 class="text-2xl font-black text-[#0F3D2F] tracking-tight">
                El Campesino
            </h1>
            <p class="text-xs uppercase font-bold text-amber-700 tracking-wider mt-1">
                MiniMarket & Control de Inventario
            </p>
        </div>

        <!-- ALERTAS -->
        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1">
                @foreach($errors->all() as $error)
                    <p class="flex items-center space-x-1">
                        <span>⚠️</span>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <!-- FORMULARIO -->
        <form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">
                    Correo Electrónico o Usuario
                </label>
                <input
                    id="email"
                    name="email"
                    type="text"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0F3D2F] focus:border-transparent text-sm bg-slate-50 transition"
                    placeholder="admin@campesino.com">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase text-slate-600">
                        Contraseña
                    </label>
                    <span class="text-[11px] text-slate-400">3 intentos max</span>
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0F3D2F] focus:border-transparent text-sm bg-slate-50 transition"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-[#0F3D2F] focus:ring-[#0F3D2F]">
                    <span>Recordar sesión</span>
                </label>
                <span class="text-emerald-800 font-medium cursor-help" title="Contacta al Administrador si olvidaste la contraseña">¿Olvidaste la clave?</span>
            </div>

            <button
                type="submit"
                class="w-full bg-[#0F3D2F] hover:bg-emerald-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-900/20 transition-all text-sm flex items-center justify-center space-x-2">
                <span>Ingresar al Sistema</span>
                <span>→</span>
            </button>
        </form>

        <!-- ACCESOS RÁPIDOS PARA PRUEBAS Y SUSTENTACIÓN -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold text-center mb-3">
                Credenciales de Prueba (Proyecto Integrador)
            </p>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button"
                        onclick="document.getElementById('email').value='admin@campesino.com'; document.getElementById('password').value='admin123';"
                        class="p-2.5 rounded-xl border border-amber-200 bg-amber-50 hover:bg-amber-100 text-left transition text-slate-700">
                    <p class="font-bold text-amber-900 text-[11px]">👑 Admin</p>
                    <p class="text-[10px] text-slate-500">admin@campesino.com</p>
                    <p class="text-[10px] text-slate-400">clave: admin123</p>
                </button>
                <button type="button"
                        onclick="document.getElementById('email').value='cajero@campesino.com'; document.getElementById('password').value='cajero123';"
                        class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-left transition text-slate-700">
                    <p class="font-bold text-emerald-900 text-[11px]">🛒 Cajero</p>
                    <p class="text-[10px] text-slate-500">cajero@campesino.com</p>
                    <p class="text-[10px] text-slate-400">clave: cajero123</p>
                </button>
            </div>
        </div>

    </div>

</body>
</html>
