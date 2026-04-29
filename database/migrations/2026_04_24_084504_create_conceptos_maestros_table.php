<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla unificada que consolida conceptos_er, compromisos_poa y lineas_productos
        Schema::create('conceptos_maestros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('categoria'); // 'ER', 'POA', 'LINEA_PRODUCTO'
            $table->string('unidad_medida')->nullable(); // De compromisos_poa
            $table->integer('orden')->default(0); // De compromisos_poa
            $table->string('label_fila_1')->nullable(); // De compromisos_poa
            $table->string('label_fila_2')->nullable(); // De compromisos_poa
            $table->integer('numero')->nullable(); // De lineas_productos
            $table->text('descripcion')->nullable(); // De conceptos_er
            $table->timestamps();

            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conceptos_maestros');
    }
};
