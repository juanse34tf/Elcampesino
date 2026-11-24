<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoteInventario;
use App\Models\MovimientoKardex;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntradaController extends Controller
{
    public function index(): View
    {
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();

        $entradasRecientes = LoteInventario::with(['producto', 'proveedor'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.entradas', compact('proveedores', 'productos', 'entradasRecientes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'producto_id' => ['required', 'exists:productos,id'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
            'numero_lote' => ['required', 'string', 'max:50'],
            'cantidad' => ['required', 'numeric', 'min:0.01'],
            'costo_compra' => ['required', 'numeric', 'min:0'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_vencimiento' => ['required', 'date', 'after_or_equal:fecha_ingreso'],
        ]);

        DB::transaction(function () use ($validated) {
            $lote = LoteInventario::create([
                'producto_id' => $validated['producto_id'],
                'proveedor_id' => $validated['proveedor_id'] ?? null,
                'numero_lote' => $validated['numero_lote'],
                'stock_actual' => $validated['cantidad'],
                'costo_compra' => $validated['costo_compra'],
                'fecha_ingreso' => $validated['fecha_ingreso'],
                'fecha_vencimiento' => $validated['fecha_vencimiento'],
            ]);

            MovimientoKardex::create([
                'producto_id' => $validated['producto_id'],
                'lote_id' => $lote->id,
                'user_id' => Auth::id() ?? 1,
                'tipo' => 'ENTRADA',
                'cantidad' => $validated['cantidad'],
                'motivo' => "Recepción de mercancía - Lote #{$validated['numero_lote']}",
            ]);
        });

        return redirect()->route('admin.entradas.index')->with('success', 'Entrada de mercancía registrada exitosamente y stock actualizado en Kardex.');
    }
}
