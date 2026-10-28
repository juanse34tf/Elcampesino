@extends('layouts.app')

@section('title', 'Catálogo de Productos — El Campesino')

@section('content')
<div class="space-y-8">

    <!-- HERO / BANNER -->
    <div class="bg-gradient-to-r from-emerald-800 to-teal-700 text-white rounded-2xl p-6 sm:p-10 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <span class="bg-emerald-600/60 text-emerald-200 text-xs uppercase font-bold tracking-wider px-3 py-1 rounded-full">
                Frescura Garantizada
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-3">
                Carnes y Pollos "El Campesino"
            </h1>
            <p class="text-emerald-100 max-w-xl text-sm sm:text-base mt-2">
                Pide tus cortes frescos y productos de despensa a domicilio sin filas ni demoras.
            </p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20 text-center">
            <p class="text-xs text-emerald-200">Horario de Domicilios</p>
            <p class="font-bold text-lg">7:00 AM — 7:00 PM</p>
            <span class="inline-block mt-1 text-xs bg-emerald-400 text-stone-900 font-semibold px-2 py-0.5 rounded">Abierto</span>
        </div>
    </div>

    <!-- NOTA GUÍA PARA EL COMPAÑERO -->
    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl">
        <div class="flex items-start">
            <span class="text-xl mr-3">🛠️</span>
            <div>
                <h3 class="text-sm font-bold text-amber-900">Base lista para maquetación (Figma)</h3>
                <p class="text-xs text-amber-800 mt-1">
                    Aquí tu compañero puede empezar a conectar los componentes. Tailwind v4 ya está compilando al vuelo.
                    Para ver cambios en tiempo real ejecutar: <code class="bg-amber-200/60 px-1 py-0.5 rounded font-mono">npm run dev</code> y <code class="bg-amber-200/60 px-1 py-0.5 rounded font-mono">php artisan serve</code>.
                </p>
            </div>
        </div>
    </div>

    <!-- FILTROS POR CATEGORÍA -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-2">
        <button class="bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg text-sm shadow-sm">
            Todos
        </button>
        <button class="bg-white hover:bg-stone-100 text-stone-700 font-medium px-4 py-2 rounded-lg text-sm border border-stone-200 transition">
            Carnes Rojas
        </button>
        <button class="bg-white hover:bg-stone-100 text-stone-700 font-medium px-4 py-2 rounded-lg text-sm border border-stone-200 transition">
            Pollos
        </button>
        <button class="bg-white hover:bg-stone-100 text-stone-700 font-medium px-4 py-2 rounded-lg text-sm border border-stone-200 transition">
            Abarrotes
        </button>
    </div>

    <!-- CUADRÍCULA DE PRODUCTOS (DEMO MAQUETA) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- CARD 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
            <div class="p-4">
                <div class="h-40 bg-stone-100 rounded-lg flex items-center justify-center text-4xl mb-3">
                    🥩
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Carnes Rojas</span>
                <h3 class="font-bold text-stone-900 mt-1">Lomo de Res</h3>
                <p class="text-xs text-stone-500 mt-1">Corte suave, especial para asar o freír.</p>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-lg font-extrabold text-stone-900">$18.500 <span class="text-xs text-stone-500 font-normal">/ lb</span></span>
                    <span class="text-xs text-emerald-600 font-medium">Stock: 15 lb</span>
                </div>
            </div>
            <div class="p-4 pt-0">
                <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-medium py-2 rounded-lg text-sm transition">
                    + Agregar al Carrito
                </button>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
            <div class="p-4">
                <div class="h-40 bg-stone-100 rounded-lg flex items-center justify-center text-4xl mb-3">
                    🍗
                </div>
                <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded">Pollos</span>
                <h3 class="font-bold text-stone-900 mt-1">Pechuga Campesina</h3>
                <p class="text-xs text-stone-500 mt-1">Fresca, lista para filetear o desmechar.</p>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-lg font-extrabold text-stone-900">$14.000 <span class="text-xs text-stone-500 font-normal">/ kg</span></span>
                    <span class="text-xs text-emerald-600 font-medium">Stock: 22 kg</span>
                </div>
            </div>
            <div class="p-4 pt-0">
                <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-medium py-2 rounded-lg text-sm transition">
                    + Agregar al Carrito
                </button>
            </div>
        </div>

        <!-- CARD 3 (Alerta de stock bajo) -->
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
            <div class="p-4">
                <div class="h-40 bg-stone-100 rounded-lg flex items-center justify-center text-4xl mb-3">
                    🥓
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Carnes</span>
                <h3 class="font-bold text-stone-900 mt-1">Costilla de Cerdo</h3>
                <p class="text-xs text-stone-500 mt-1">Ideal para sancocho o guisar.</p>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="text-lg font-extrabold text-stone-900">$12.500 <span class="text-xs text-stone-500 font-normal">/ lb</span></span>
                    <span class="text-xs text-rose-600 font-bold">Últimas 3 lb</span>
                </div>
            </div>
            <div class="p-4 pt-0">
                <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-medium py-2 rounded-lg text-sm transition">
                    + Agregar al Carrito
                </button>
            </div>
        </div>

        <!-- CARD 4 (Placeholder para nuevo) -->
        <div class="border-2 border-dashed border-stone-300 rounded-xl flex flex-col items-center justify-center p-6 text-center hover:border-emerald-500 transition cursor-pointer">
            <span class="text-3xl text-stone-400">+</span>
            <p class="text-sm font-semibold text-stone-600 mt-2">Agregar más cards</p>
            <p class="text-xs text-stone-400 mt-1">Tu compañero puede copiar la estructura</p>
        </div>

    </div>

</div>
@endsection
