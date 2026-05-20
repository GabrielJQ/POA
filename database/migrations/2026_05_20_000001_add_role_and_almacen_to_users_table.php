<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('capturista')->after('email');
            $table->foreignId('almacen_id')->nullable()->after('role')
                ->constrained('almacenes')->nullOnDelete();
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['almacen_id']);
            $table->dropIndex(['role']);
            $table->dropColumn(['role', 'almacen_id']);
        });
    }
};
