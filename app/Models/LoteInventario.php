<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoteInventario extends Model
{
    use HasFactory;

    protected $table = 'lotes_inventario';

    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'numero_lote',
        'stock_actual',
        'costo_compra',
        'fecha_ingreso',
        'fecha_vencimiento',
    ];

    protected $casts = [
        'stock_actual' => 'decimal:2',
        'costo_compra' => 'decimal:2',
        'fecha_ingreso' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoKardex::class, 'lote_id');
    }

    public function getDiasParaVencerAttribute(): int
    {
        return (int) Carbon::now()->startOfDay()->diffInDays(Carbon::parse($this->fecha_vencimiento)->startOfDay(), false);
    }

    public function getEstadoVencimientoAttribute(): string
    {
        $dias = $this->dias_para_vencer;
        if ($dias < 0) {
            return 'VENCIDO';
        }
        if ($dias <= 7) {
            return 'CRITICO';
        }
        if ($dias <= 30) {
            return 'PROXIMO';
        }
        return 'OPTIMO';
    }
}
