<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poa_notas', function (Blueprint $table) {
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('cascade')->after('concepto_id');
            $table->integer('mes')->default(0)->after('anio');

            $table->dropUnique('poa_notas_unique');
            $table->unique(['concepto_id', 'label', 'anio', 'almacen_id', 'mes'], 'poa_notas_unique');
        });
    }

    public function down(): void
    {
        Schema::table('poa_notas', function (Blueprint $table) {
            $table->dropUnique('poa_notas_unique');
            $table->dropColumn(['almacen_id', 'mes']);
            $table->unique(['concepto_id', 'label', 'anio'], 'poa_notas_unique');
        });
    }
};
