<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventarioController extends Controller
{
    public function index(Request $request): View
    {
        $query = Producto::with(['categoria', 'lotes'])->latest();

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('codigo_barras', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $productos = $query->paginate(15)->withQueryString();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.inventario', compact('productos', 'categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'codigo_barras' => ['nullable', 'string', 'max:50', 'unique:productos,codigo_barras'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock_minimo' => ['required', 'numeric', 'min:0'],
            'unidad_medida' => ['required', 'in:KG,LB,UNIDAD,PAQUETE'],
        ]);

        Producto::create($validated);

        return redirect()->route('admin.inventario.index')->with('success', 'Producto registrado correctamente en el catálogo.');
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'codigo_barras' => ['nullable', 'string', 'max:50', 'unique:productos,codigo_barras,' . $producto->id],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock_minimo' => ['required', 'numeric', 'min:0'],
            'unidad_medida' => ['required', 'in:KG,LB,UNIDAD,PAQUETE'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $request->has('activo');

        $producto->update($validated);

        return redirect()->route('admin.inventario.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        // Retiro suave (desactivar) para conservar histórico según requerimiento del proyecto
        $producto->update(['activo' => false]);

        return redirect()->route('admin.inventario.index')->with('success', 'Producto retirado de la venta (histórico conservado).');
    }
}
