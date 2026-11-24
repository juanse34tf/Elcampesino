<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'telefono',
        'direccion',
        'intentos_fallidos',
        'bloqueado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bloqueado' => 'boolean',
            'intentos_fallidos' => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->rol === 'ADMIN';
    }

    public function isEmpleado(): bool
    {
        return $this->rol === 'EMPLEADO';
    }

    public function isRepartidor(): bool
    {
        return $this->rol === 'REPARTIDOR';
    }

    public function isCliente(): bool
    {
        return $this->rol === 'CLIENTE';
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoKardex::class, 'user_id');
    }

    public function pedidosCliente(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function pedidosRepartidor(): HasMany
    {
        return $this->hasMany(Pedido::class, 'repartidor_id');
    }
}
