<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'codigo_barras',
        'precio',
        'stock_minimo',
        'unidad_medida',
        'imagen_url',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function lotes(): HasMany
    {
        return $this->hasMany(LoteInventario::class, 'producto_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoKardex::class, 'producto_id');
    }

    public function getStockTotalAttribute(): float
    {
        return (float) $this->lotes()->sum('stock_actual');
    }

    public function estaEnStockBajo(): bool
    {
        $stock = $this->stock_total;
        return $stock > 0 && $stock <= (float) $this->stock_minimo;
    }

    public function estaAgotado(): bool
    {
        return $this->stock_total <= 0;
    }
}
