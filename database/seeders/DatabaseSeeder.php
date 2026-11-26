<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\LoteInventario;
use App\Models\MovimientoKardex;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. USUARIOS
        $admin = User::create([
            'name' => 'Juan Sebastián (Admin)',
            'email' => 'admin@campesino.com',
            'password' => Hash::make('admin123'),
            'rol' => 'ADMIN',
            'telefono' => '3157894512',
            'direccion' => 'Calle 10 # 5-20, Cali',
            'intentos_fallidos' => 0,
            'bloqueado' => false,
        ]);

        $cajero = User::create([
            'name' => 'Cajero Turno Principal',
            'email' => 'cajero@campesino.com',
            'password' => Hash::make('cajero123'),
            'rol' => 'EMPLEADO',
            'telefono' => '3189998877',
            'direccion' => 'Av. Roosevelt # 34-12, Cali',
            'intentos_fallidos' => 0,
            'bloqueado' => false,
        ]);

        // 2. CATEGORÍAS
        $catPollos = Categoria::create([
            'nombre' => 'Pollos y Aves',
            'descripcion' => 'Pollo campesino fresco, pechuga, muslos y alas',
        ]);

        $catCarnes = Categoria::create([
            'nombre' => 'Carnes Rojas',
            'descripcion' => 'Cortes finos de res, cerdo y vísceras seleccionadas',
        ]);

        $catAbarrotes = Categoria::create([
            'nombre' => 'Abarrotes y Granos',
            'descripcion' => 'Arroz, frijol, lenteja, aceites y víveres esenciales',
        ]);

        $catLacteos = Categoria::create([
            'nombre' => 'Lácteos y Huevos',
            'descripcion' => 'Queso campesino, cuajada, leche y panales de huevos',
        ]);

        // 3. PROVEEDORES
        $provAvicola = Proveedor::create([
            'nombre' => 'Avícola La Colina S.A.S',
            'nit_cedula' => '900.123.456-1',
            'telefono' => '3155550101',
            'email' => 'ventas@avicolalacolina.com',
            'direccion' => 'Km 7 Vía Candelaria, Valle',
            'activo' => true,
        ]);

        $provFrigorifico = Proveedor::create([
            'nombre' => 'Frigorífico del Valle',
            'nit_cedula' => '890.987.654-2',
            'telefono' => '3104440202',
            'email' => 'contacto@frigorificovalle.com',
            'direccion' => 'Zona Industrial Acopi, Yumbo',
            'activo' => true,
        ]);

        $provGranos = Proveedor::create([
            'nombre' => 'Distribuidora Central Cavasa',
            'nit_cedula' => '800.333.222-3',
            'telefono' => '3123330303',
            'email' => 'pedidos@cavasa.com.co',
            'direccion' => 'Cavasa Bodega 14, Candelaria',
            'activo' => true,
        ]);

        // 4. PRODUCTOS
        $pechuga = Producto::create([
            'categoria_id' => $catPollos->id,
            'nombre' => 'Pechuga de Pollo Campesino',
            'codigo_barras' => '7701234001',
            'precio' => 16500.00,
            'stock_minimo' => 15.00,
            'unidad_medida' => 'KG',
            'activo' => true,
        ]);

        $lomoRes = Producto::create([
            'categoria_id' => $catCarnes->id,
            'nombre' => 'Lomo Fino de Res',
            'codigo_barras' => '7701234002',
            'precio' => 36000.00,
            'stock_minimo' => 10.00,
            'unidad_medida' => 'KG',
            'activo' => true,
        ]);

        $costilla = Producto::create([
            'categoria_id' => $catCarnes->id,
            'nombre' => 'Costilla de Cerdo Especial',
            'codigo_barras' => '7701234003',
            'precio' => 22000.00,
            'stock_minimo' => 8.00,
            'unidad_medida' => 'KG',
            'activo' => true,
        ]);

        $arroz = Producto::create([
            'categoria_id' => $catAbarrotes->id,
            'nombre' => 'Arroz Diana Blanco 1KG',
            'codigo_barras' => '7701234004',
            'precio' => 4600.00,
            'stock_minimo' => 30.00,
            'unidad_medida' => 'PAQUETE',
            'activo' => true,
        ]);

        $queso = Producto::create([
            'categoria_id' => $catLacteos->id,
            'nombre' => 'Queso Campesino Artesanal',
            'codigo_barras' => '7701234005',
            'precio' => 8500.00,
            'stock_minimo' => 12.00,
            'unidad_medida' => 'LB',
            'activo' => true,
        ]);

        // Producto en stock crítico/agotado para disparar alerta en dashboard
        $polloEntero = Producto::create([
            'categoria_id' => $catPollos->id,
            'nombre' => 'Pollo Entero Despresado',
            'codigo_barras' => '7701234006',
            'precio' => 13500.00,
            'stock_minimo' => 10.00,
            'unidad_medida' => 'KG',
            'activo' => true,
        ]);

        // 5. LOTES DE INVENTARIO
        // Lote 1: Pechuga fresco
        $lote1 = LoteInventario::create([
            'producto_id' => $pechuga->id,
            'proveedor_id' => $provAvicola->id,
            'numero_lote' => 'LOT-POL-202611-01',
            'stock_actual' => 25.00,
            'costo_compra' => 12500.00,
            'fecha_ingreso' => Carbon::now()->subDays(2),
            'fecha_vencimiento' => Carbon::now()->addDays(12),
        ]);

        // Lote 2: Pechuga por vencer (CRÍTICO: vence en 4 días) para demostración de alertas
        $lote2 = LoteInventario::create([
            'producto_id' => $pechuga->id,
            'proveedor_id' => $provAvicola->id,
            'numero_lote' => 'LOT-POL-202610-25',
            'stock_actual' => 6.50,
            'costo_compra' => 12000.00,
            'fecha_ingreso' => Carbon::now()->subDays(10),
            'fecha_vencimiento' => Carbon::now()->addDays(4),
        ]);

        // Lote 3: Lomo de Res (Stock bajo para alertas)
        $lote3 = LoteInventario::create([
            'producto_id' => $lomoRes->id,
            'proveedor_id' => $provFrigorifico->id,
            'numero_lote' => 'LOT-RES-202611-05',
            'stock_actual' => 4.00, // Stock menor al mínimo (10)
            'costo_compra' => 28000.00,
            'fecha_ingreso' => Carbon::now()->subDays(3),
            'fecha_vencimiento' => Carbon::now()->addDays(18),
        ]);

        // Lote 4: Costilla de Cerdo
        $lote4 = LoteInventario::create([
            'producto_id' => $costilla->id,
            'proveedor_id' => $provFrigorifico->id,
            'numero_lote' => 'LOT-CER-202611-02',
            'stock_actual' => 18.00,
            'costo_compra' => 17000.00,
            'fecha_ingreso' => Carbon::now()->subDays(4),
            'fecha_vencimiento' => Carbon::now()->addDays(22),
        ]);

        // Lote 5: Arroz
        $lote5 = LoteInventario::create([
            'producto_id' => $arroz->id,
            'proveedor_id' => $provGranos->id,
            'numero_lote' => 'LOT-ARR-202610-15',
            'stock_actual' => 80.00,
            'costo_compra' => 3800.00,
            'fecha_ingreso' => Carbon::now()->subDays(15),
            'fecha_vencimiento' => Carbon::now()->addMonths(6),
        ]);

        // Lote 6: Queso próximo a vencer (vence en 6 días)
        $lote6 = LoteInventario::create([
            'producto_id' => $queso->id,
            'proveedor_id' => $provGranos->id,
            'numero_lote' => 'LOT-QUE-202611-01',
            'stock_actual' => 9.00,
            'costo_compra' => 6500.00,
            'fecha_ingreso' => Carbon::now()->subDays(5),
            'fecha_vencimiento' => Carbon::now()->addDays(6),
        ]);

        // 6. MOVIMIENTOS KARDEX INICIALES
        $lotes = [$lote1, $lote2, $lote3, $lote4, $lote5, $lote6];
        foreach ($lotes as $l) {
            MovimientoKardex::create([
                'producto_id' => $l->producto_id,
                'lote_id' => $l->id,
                'user_id' => $admin->id,
                'tipo' => 'ENTRADA',
                'cantidad' => $l->stock_actual,
                'motivo' => "Recepción inicial proveedor #{$l->proveedor_id} - Lote {$l->numero_lote}",
                'created_at' => $l->fecha_ingreso,
            ]);
        }
    }
}
