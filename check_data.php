<?php
// Script para sincronizar datos POA desde ER
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new App\Services\POAService();

// Sincronizar Almacén 1 (Ayutla Mixes) - Año 2026
echo "Sincronizando Almacén 1 (Ayutla Mixes) - 2026...\n";
$count1 = $service->syncFromER(1, 2026);
echo "Compromisos sincronizados: {$count1}\n";

// Sincronizar Almacén 8 (CUAJIMOLOYAS) - Año 2026
echo "Sincronizando Almacén 8 (CUAJIMOLOYAS) - 2026...\n";
$count2 = $service->syncFromER(8, 2026);
echo "Compromisos sincronizados: {$count2}\n";

// Verificar resultados
echo "\n=== REGISTROS POA CREADOS ===\n";
$registros = App\Models\PoaRegistro::with(['compromiso', 'almacen'])->where('almacen_id', 1)->get();
foreach ($registros as $r) {
    echo sprintf(
        "%-45s | %-15s | Meta: %12s | Ene: %12s\n",
        $r->compromiso->nombre,
        $r->tipo_registro,
        number_format($r->meta_anual, 2),
        number_format($r->mes_01, 2)
    );
}
