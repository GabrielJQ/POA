<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE registros_financieros ALTER COLUMN monto DROP DEFAULT');
            DB::statement('ALTER TABLE registros_financieros ALTER COLUMN monto TYPE numeric(15,2) USING monto::numeric(15,2)');
            DB::statement('ALTER TABLE registros_financieros ALTER COLUMN monto SET DEFAULT \'0\'');
            DB::statement('ALTER TABLE registros_financieros ALTER COLUMN monto SET NOT NULL');
        } else {
            Schema::table('registros_financieros', function (Blueprint $table) {
                $table->decimal('monto', 15, 2)->default(0)->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('registros_financieros', function (Blueprint $table) {
            $table->text('monto')->nullable(false)->default('')->change();
        });
    }
};
