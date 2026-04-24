<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resultados_mensuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->foreignId('concepto_er_id')->constrained('conceptos_er')->onDelete('cascade');
            $table->integer('anio');
            $table->integer('mes');
            $table->decimal('monto', 18, 2);
            $table->timestamps();

            // Índice único compuesto para integridad financiera
            $table->unique(['almacen_id', 'concepto_er_id', 'anio', 'mes'], 'idx_resultado_mensual_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados_mensuales');
    }
};
