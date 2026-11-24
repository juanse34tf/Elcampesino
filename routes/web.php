<?php

use App\Http\Controllers\Admin\AlertaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EntradaController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\MovimientoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Vendedor\DashboardController as VendedorDashboardController;
use Illuminate\Support\Facades\Route;
// ==========================================
// AUTENTICACIÓN
// ==========================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// MÓDULO ADMINISTRADOR (Control de Acceso: ADMIN)
// ==========================================
Route::middleware(['rol:ADMIN'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
    Route::put('/inventario/{producto}', [InventarioController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/{producto}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

    // Entradas de mercancía y lotes
    Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
    Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');

    // Movimientos Kardex y Ajustes
    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::post('/movimientos/ajuste', [MovimientoController::class, 'storeAjuste'])->name('movimientos.ajuste');

    // Alertas
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');

    // Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::patch('/usuarios/{usuario}/bloqueo', [UsuarioController::class, 'toggleBloqueo'])->name('usuarios.bloqueo');
});

// ==========================================
// MÓDULO EMPLEADO / VENDEDOR (Control de Acceso: ADMIN o EMPLEADO)
// ==========================================
Route::middleware(['rol:ADMIN,EMPLEADO'])->prefix('vendedor')->name('vendedor.')->group(function () {
    Route::get('/dashboard', [VendedorDashboardController::class, 'index'])->name('dashboard');
});
