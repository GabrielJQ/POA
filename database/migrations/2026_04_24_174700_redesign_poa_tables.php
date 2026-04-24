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
        // Eliminar tabla anterior (diseño incorrecto)
        Schema::dropIfExists('poas');

        // Tabla de definición de compromisos del POA
        Schema::create('compromisos_poa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                     // Ej: "PRESUPUESTO DE VENTA PAR"
            $table->string('unidad_medida');               // Ej: "PESOS", "PORCENTAJE", "NÚMERO DE TIENDAS"
            $table->integer('orden')->default(0);          // Orden visual en la tabla
            $table->string('concepto_er_nombre')->nullable(); // Nombre del concepto en ER para mapeo automático
            $table->string('label_fila_1')->default('COMPROMETIDO');  // Etiqueta fila 1
            $table->string('label_fila_2')->default('REALIZADO');     // Etiqueta fila 2
            $table->timestamps();
        });

        // Tabla de registros POA (datos mensuales)
        Schema::create('poa_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compromiso_poa_id')->constrained('compromisos_poa')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->integer('anio');
            $table->string('tipo_registro');               // 'COMPROMETIDO', 'REALIZADO', etc.
            $table->decimal('meta_anual', 18, 2)->default(0);
            
            // Desglose mensual (12 columnas)
            $table->decimal('mes_01', 18, 2)->default(0);
            $table->decimal('mes_02', 18, 2)->default(0);
            $table->decimal('mes_03', 18, 2)->default(0);
            $table->decimal('mes_04', 18, 2)->default(0);
            $table->decimal('mes_05', 18, 2)->default(0);
            $table->decimal('mes_06', 18, 2)->default(0);
            $table->decimal('mes_07', 18, 2)->default(0);
            $table->decimal('mes_08', 18, 2)->default(0);
            $table->decimal('mes_09', 18, 2)->default(0);
            $table->decimal('mes_10', 18, 2)->default(0);
            $table->decimal('mes_11', 18, 2)->default(0);
            $table->decimal('mes_12', 18, 2)->default(0);

            $table->text('nota_aclaratoria')->nullable();
            $table->timestamps();

            // Índice único: un registro por compromiso, almacén, año y tipo
            $table->unique(
                ['compromiso_poa_id', 'almacen_id', 'anio', 'tipo_registro'],
                'idx_poa_registro_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poa_registros');
        Schema::dropIfExists('compromisos_poa');
    }
};
