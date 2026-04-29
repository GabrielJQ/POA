<?php
require 'vendor/autoload.php';
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RegistroFinanciero;
use App\Models\Almacen;

$path = '../../PT FORMATO 01 2026 (PROFORMA)_CONSOLIDADO.xlsx';
$anio = 2026;

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "--- INICIANDO IMPORTACIÓN MASIVA DE PRUEBA ---\n";
    echo "Archivo: $path\n";

    // 1. Limpiar datos previos de 2026 (META) para empezar limpio
    RegistroFinanciero::where('anio', $anio)->where('tipo_dato', 'META')->delete();
    echo "Limpieza completada.\n\n";

    // 2. Obtener nombres reales de las pestañas
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
    $sheetNames = $spreadsheet->getSheetNames();
    
    // Cargar todas las hojas
    $sheetsData = Excel::toArray(new \stdClass(), $path);
    echo "Hojas detectadas: " . count($sheetsData) . "\n";

    $totalRegistros = 0;
    $almacenesOk = [];

    foreach ($sheetsData as $index => $rows) {
        $actualSheetName = $sheetNames[$index] ?? '';
        $sheetImport = new \App\Imports\ERSheetImport($anio, $actualSheetName);
        $registros = $sheetImport->import($rows);
        
        if ($registros > 0) {
            $totalRegistros += $registros;
            // Obtener el almacén que se asignó finalmente (está guardado en DB)
            $almacenDetectado = \App\Models\RegistroFinanciero::where('anio', $anio)
                ->where('tipo_dato', 'META')
                ->whereHas('almacen')
                ->latest()
                ->first()
                ?->almacen?->nombre;

            $almacenesOk[] = $almacenDetectado;
            echo "[OK] Hoja $index ($actualSheetName): Almacén Detectado '$almacenDetectado' -> $registros registros.\n";
        } else {
            echo "[SKIP] Hoja $index ($actualSheetName): No se detectó almacén oficial o datos válidos.\n";
        }
    }

    echo "\n--- RESUMEN ---\n";
    echo "Total Almacenes Procesados: " . count($almacenesOk) . "\n";
    echo "Total Registros Creados: $totalRegistros\n";
    
    // 3. Verificación final en base de datos
    $conteoFinal = RegistroFinanciero::where('anio', $anio)->where('tipo_dato', 'META')->count();
    echo "Conteo final en DB: $conteoFinal\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
