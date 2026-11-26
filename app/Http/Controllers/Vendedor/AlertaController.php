public function index(): View
    {
        $productos = Producto::with(['categoria', 'lotes'])->where('activo', true)->get();

        // Productos en riesgo de stock
        $productosAgotados = $productos->filter(fn($p) => $p->estaAgotado());
        $productosStockBajo = $productos->filter(fn($p) => $p->estaEnStockBajo());

        // Lotes por vencimiento (stock actual > 0)
        $limite30Dias = Carbon::today()->addDays(30);

        $lotesEnRiesgo = LoteInventario::where('stock_actual', '>', 0)
            ->whereDate('fecha_vencimiento', '<=', $limite30Dias)
            ->with(['producto', 'proveedor'])
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        $lotesVencidos = $lotesEnRiesgo->filter(fn($l) => $l->dias_para_vencer < 0);
        $lotesCriticos = $lotesEnRiesgo->filter(fn($l) => $l->dias_para_vencer >= 0 && $l->dias_para_vencer <= 7);
        $lotesProximos = $lotesEnRiesgo->filter(fn($l) => $l->dias_para_vencer > 7 && $l->dias_para_vencer <= 30);

        return view('admin.alertas', compact(
            'productosAgotados',
            'productosStockBajo',
            'lotesVencidos',
            'lotesCriticos',
            'lotesProximos'
        ));
    }