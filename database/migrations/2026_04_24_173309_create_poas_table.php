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
        Schema::create('poas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->integer('anio');
            $table->string('tipo_registro')->default('COMPROMETIDO');
            
            // Metas Comprometidas (Mapping solicitado)
            $table->decimal('presupuesto_venta_par', 18, 2)->default(0);
            $table->decimal('presupuesto_venta_pe', 18, 2)->default(0);
            $table->decimal('presupuesto_venta_total', 18, 2)->default(0);
            $table->decimal('resultado_directo_operacion', 18, 2)->default(0);

            $table->timestamps();

            // Índice único para evitar duplicados por almacén, año y tipo
            $table->unique(['almacen_id', 'anio', 'tipo_registro'], 'idx_poa_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poas');
    }
};
