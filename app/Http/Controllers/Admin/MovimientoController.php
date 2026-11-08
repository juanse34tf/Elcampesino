<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoteInventario;
use App\Models\MovimientoKardex;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MovimientoController extends Controller
{
    public function index(Request $request): View
    {
        $query = MovimientoKardex::with(['producto', 'lote', 'usuario'])->latest();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->input('producto_id'));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->input('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->input('fecha_hasta'));
        }

        $movimientos = $query->paginate(20)->withQueryString();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $lotesDisponibles = LoteInventario::where('stock_actual', '>', 0)->with('producto')->get();

        return view('admin.movimientos', compact('movimientos', 'productos', 'lotesDisponibles'));
    }

    public function storeAjuste(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lote_id' => ['required', 'exists:lotes_inventario,id'],
            'tipo_ajuste' => ['required', 'in:INCREMENTO,DISMINUCION'],
            'cantidad' => ['required', 'numeric', 'min:0.01'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $lote = LoteInventario::findOrFail($validated['lote_id']);
            $cantidad = (float) $validated['cantidad'];

            if ($validated['tipo_ajuste'] === 'INCREMENTO') {
                $lote->increment('stock_actual', $cantidad);
                $tipoKardex = 'AJUSTE';
                $delta = $cantidad;
            } else {
                if ($lote->stock_actual < $cantidad) {
                    abort(422, 'La cantidad a descontar supera el stock actual del lote.');
                }
                $lote->decrement('stock_actual', $cantidad);
                $tipoKardex = 'SALIDA';
                $delta = $cantidad;
            }

            MovimientoKardex::create([
                'producto_id' => $lote->producto_id,
                'lote_id' => $lote->id,
                'user_id' => Auth::id() ?? 1,
                'tipo' => $tipoKardex,
                'cantidad' => $delta,
                'motivo' => "[Ajuste Manual] " . $validated['motivo'],
            ]);
        });

        return redirect()->route('admin.movimientos.index')->with('success', 'Ajuste de inventario registrado y auditado correctamente en el Kardex.');
    }
}
