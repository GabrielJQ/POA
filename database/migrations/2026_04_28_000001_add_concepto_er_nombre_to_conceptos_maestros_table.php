<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conceptos_maestros', function (Blueprint $table) {
            $table->string('concepto_er_nombre')->nullable()->after('categoria');
        });
    }

    public function down(): void
    {
        Schema::table('conceptos_maestros', function (Blueprint $table) {
            $table->dropColumn('concepto_er_nombre');
        });
    }
};
