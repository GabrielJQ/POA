<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla central (Fact Table) que unifica resultados_mensuales, ventas_par_pe y poa_registro_detalles
        Schema::create('registros_financieros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->foreignId('concepto_id')->constrained('conceptos_maestros')->onDelete('cascade');
            $table->integer('mes');
            $table->integer('anio');
            $table->decimal('monto', 15, 2)->default(0);
            $table->string('tipo_dato'); // 'REAL', 'PROYECTADO', 'META'
            $table->string('programa', 10)->nullable(); // 'PAR', 'PE' para ventas
            $table->timestamps();

            $table->unique(['almacen_id', 'concepto_id', 'mes', 'anio', 'tipo_dato', 'programa'], 'registros_financieros_unique');
            $table->index(['almacen_id', 'mes', 'anio'], 'registros_financieros_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_financieros');
    }
};
