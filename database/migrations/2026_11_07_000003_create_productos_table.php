<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->string('nombre', 120);
            $table->string('codigo_barras', 50)->unique()->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('stock_minimo', 10, 2)->default(5.00);
            $table->enum('unidad_medida', ['KG', 'LB', 'UNIDAD', 'PAQUETE'])->default('KG');
            $table->string('imagen_url', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
