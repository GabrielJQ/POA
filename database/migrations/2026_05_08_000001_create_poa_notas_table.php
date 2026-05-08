<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poa_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concepto_id')->constrained('conceptos_maestros')->onDelete('cascade');
            $table->string('label', 50);
            $table->integer('anio');
            $table->text('nota_aclaratoria')->nullable();
            $table->timestamps();

            $table->unique(['concepto_id', 'label', 'anio'], 'poa_notas_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poa_notas');
    }
};
