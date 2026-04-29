<?php
require 'vendor/autoload.php';
use App\Domain\Services\PDFERExtractorService;
use App\Models\RegistroFinanciero;
use App\Models\Almacen;

$path = 'C:/Users/qange/Downloads/01Enero.pdf';
$anio = 2025;

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "--- INICIANDO EXTRACCIÓN PDF MULTI-ALMACÉN ---\n";
    echo "Archivo: $path\n";

    // 1. Limpiar datos REALES previos para este mes/año (opcional para la prueba)
    // RegistroFinanciero::where('anio', $anio)->where('tipo_dato', 'REAL')->delete();

    // 2. Ejecutar servicio
    $service = new PDFERExtractorService();
    $result = $service->extract($path, $anio);

    echo "PDF Procesado con éxito!\n";
    echo "Mes Detectado: " . $result['mes'] . "\n";
    echo "Registros Actualizados: " . $result['count'] . "\n\n";

    // 3. Verificar distribución en DB
    $resumen = RegistroFinanciero::where('anio', $anio)
        ->where('tipo_dato', 'REAL')
        ->where('mes', $result['mes'])
        ->with('almacen')
        ->get()
        ->groupBy('almacen.nombre');

    echo "DISTRIBUCIÓN POR ALMACÉN:\n";
    foreach ($resumen as $almacen => $registros) {
        echo "- $almacen: " . count($registros) . " conceptos cargados.\n";
        foreach ($registros as $reg) {
            echo "   * Concepto ID {$reg->concepto_id}: $" . number_format($reg->monto, 2) . "\n";
        }
    }

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
