<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login'  );
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/inventario', 'admin.inventario');
Route::view('/admin/entradas', 'admin.entradas');
Route::view('/admin/movimientos', 'admin.movimientos');
Route::view('/admin/alertas', 'admin.alertas');
Route::view('/admin/proveedores', 'admin.proveedores');
Route::view('/admin/usuarios', 'admin.usuarios');

Route::view('/vendedor/dashboard', 'vendedor.dashboard');
