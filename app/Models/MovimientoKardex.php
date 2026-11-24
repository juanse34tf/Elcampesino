<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoKardex extends Model
{
    use HasFactory;

    protected $table = 'movimientos_kardex';

    protected $fillable = [
        'producto_id',
        'lote_id',
        'user_id',
        'tipo',
        'cantidad',
        'motivo',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function lote(): BelongsTo
    {
        return $this->belongsTo(LoteInventario::class, 'lote_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
