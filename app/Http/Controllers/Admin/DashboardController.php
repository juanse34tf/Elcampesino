<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\LoteInventario;
use App\Models\MovimientoKardex;
use App\Models\Producto;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $hoy = Carbon::today();
        $proximoMes = Carbon::today()->addDays(30);

        $totalProductos = Producto::where('activo', true)->count();
        $totalProveedores = Proveedor::where('activo', true)->count();

        // Lotes próximos a vencer (en los próximos 30 días con stock > 0)
        $lotesPorVencer = LoteInventario::where('stock_actual', '>', 0)
            ->whereDate('fecha_vencimiento', '<=', $proximoMes)
            ->with(['producto', 'proveedor'])
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        // Lotes críticos (vencidos o a vencer en <= 7 días)
        $lotesCriticosCount = $lotesPorVencer->filter(fn($lote) => $lote->dias_para_vencer <= 7)->count();

        // Productos con stock bajo
        $productos = Producto::with('lotes')->where('activo', true)->get();
        $productosStockBajo = $productos->filter(fn($p) => $p->estaEnStockBajo() || $p->estaAgotado());
        $productosAgotadosCount = $productos->filter(fn($p) => $p->estaAgotado())->count();

        // Valor total del inventario (costo compra * stock actual)
        $valorTotalInventario = LoteInventario::sum(\DB::raw('stock_actual * costo_compra'));

        // Movimientos recientes
        $movimientosRecientes = MovimientoKardex::with(['producto', 'lote', 'usuario'])
            ->latest()
            ->take(8)
            ->get();

        // Categorías con conteo
        $categorias = Categoria::withCount('productos')->get();

        return view('admin.dashboard', compact(
            'totalProductos',
            'totalProveedores',
            'lotesPorVencer',
            'lotesCriticosCount',
            'productosStockBajo',
            'productosAgotadosCount',
            'valorTotalInventario',
            'movimientosRecientes',
            'categorias'
        ));
    }
}
