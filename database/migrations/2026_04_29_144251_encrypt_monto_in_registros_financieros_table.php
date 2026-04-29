<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Limpiar la tabla antes del cambio para evitar errores de descifrado con datos viejos
        DB::table('registros_financieros')->truncate();

        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->text('monto')->nullable(false)->default('')->change();
        });
    }

    public function down(): void
    {
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->decimal('monto', 15, 2)->default(0)->change();
        });
    }
};
