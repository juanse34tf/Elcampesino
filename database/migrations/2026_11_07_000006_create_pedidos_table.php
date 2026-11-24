<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('repartidor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado', ['REGISTRADO', 'EN_PREPARACION', 'LISTO_DESPACHO', 'EN_RUTA', 'ENTREGADO', 'CANCELADO'])->default('REGISTRADO');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->string('direccion_entrega', 255);
            $table->string('telefono_contacto', 20);
            $table->enum('metodo_pago', ['EFECTIVO', 'TRANSFERENCIA', 'DATAFONO'])->default('EFECTIVO');
            $table->text('notas_entrega')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
