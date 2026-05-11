<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ========================================================================
        // registros_financieros (tabla crítica ~20 puntos de consulta)
        // Ya existe: UNIQUE (almacen_id, concepto_id, mes, anio, tipo_dato, programa)
        //           + INDEX (almacen_id, mes, anio)
        // ========================================================================

        // Cubre Dashboard META/REAL (1.4, 1.5), POA META/REAL (2.3, 2.4),
        // ER META (3.1), ImportarER (11.1)
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->index(['anio', 'tipo_dato'], 'idx_rf_anio_tipo');
        });

        // Cubre POA VENTAS with whereHas concepto LINEA_PRODUCTO (2.5)
        // Se optimizará en Fase B reemplazando whereHas por whereIn
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->index(['anio', 'tipo_dato', 'concepto_id'], 'idx_rf_anio_tipo_concepto');
        });

        // Cubre POA Service queries por almacén individual (5.5, 6.1, 6.2)
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->index(['almacen_id', 'anio', 'tipo_dato'], 'idx_rf_almacen_anio_tipo');
        });

        // ========================================================================
        // conceptos_maestros
        // Ya existe: INDEX (categoria)
        // ========================================================================

        // Reemplaza el index simple por uno compuesto que incluye orden
        // Cubre Dashboard (1.2), POA (2.1), ER (3.2), POAService (5.1)
        Schema::table('conceptos_maestros', function (Blueprint $table) {
            $table->dropIndex(['categoria']);
            $table->index(['categoria', 'orden'], 'idx_cm_categoria_orden');
        });

        // Cubre PDF extractor (4.1), Surtimiento (7.1, 7.2), seeders
        Schema::table('conceptos_maestros', function (Blueprint $table) {
            $table->index(['nombre', 'categoria'], 'idx_cm_nombre_categoria');
        });

        // ========================================================================
        // almacenes
        // ========================================================================

        // Cubre import lookups por nombre (4.2, 7.4, 8.3-8.5)
        Schema::table('almacenes', function (Blueprint $table) {
            $table->index(['nombre'], 'idx_almacenes_nombre');
        });

        // ========================================================================
        // poa_notas
        // Ya existe: UNIQUE (concepto_id, label, anio, almacen_id, mes)
        // ========================================================================

        // Cubre consulta POA notas por anio+mes+almacen (2.6)
        Schema::table('poa_notas', function (Blueprint $table) {
            $table->index(['anio', 'mes', 'almacen_id'], 'idx_poa_notas_lookup');
        });
    }

    public function down(): void
    {
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->dropIndex('idx_rf_anio_tipo');
            $table->dropIndex('idx_rf_anio_tipo_concepto');
            $table->dropIndex('idx_rf_almacen_anio_tipo');
        });

        Schema::table('conceptos_maestros', function (Blueprint $table) {
            $table->dropIndex('idx_cm_categoria_orden');
            $table->dropIndex('idx_cm_nombre_categoria');
            $table->index('categoria');
        });

        Schema::table('almacenes', function (Blueprint $table) {
            $table->dropIndex('idx_almacenes_nombre');
        });

        Schema::table('poa_notas', function (Blueprint $table) {
            $table->dropIndex('idx_poa_notas_lookup');
        });
    }
};
