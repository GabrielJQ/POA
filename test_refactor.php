<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Domain\Contracts\IDashboardService;
use App\Domain\Contracts\IPOADomainService;
use App\Domain\Contracts\IERDomainService;
use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\ValueObjects\FiltrosER;

echo "--- INICIANDO PRUEBA DE ESTRÉS DE REFACTOR ---\n\n";

try {
    $start = microtime(true);
    $dashboardService = app(IDashboardService::class);
    echo "1. Probando DashboardService::calcularEficiencia()...\n";
    $dashboardResult = $dashboardService->calcularEficiencia(2026);
    echo "   OK! Almacenes procesados: " . $dashboardResult['totalAlmacenes'] . "\n";
    echo "   Tiempo: " . round((microtime(true) - $start) * 1000, 2) . "ms\n\n";
    
    $start = microtime(true);
    $poaService = app(IPOADomainService::class);
    echo "2. Probando POADomainService::obtenerDatosPOA() [Consolidado Anual]...\n";
    $filtrosPoa1 = FiltrosPOA::createFromRequest(['anio' => 2026, 'periodo' => 'anual', 'consolidado' => 'si']);
    $poaResult1 = $poaService->obtenerDatosPOA($filtrosPoa1);
    echo "   OK! Conceptos POA: " . count($poaResult1['dataPoa']) . "\n";
    echo "   Tiempo: " . round((microtime(true) - $start) * 1000, 2) . "ms\n\n";

    $start = microtime(true);
    echo "3. Probando POADomainService::obtenerDatosPOA() [Almacén 1, Mensual]...\n";
    $filtrosPoa2 = FiltrosPOA::createFromRequest(['anio' => 2026, 'periodo' => 'mensual', 'mes' => 3, 'almacen_id' => 1]);
    $poaResult2 = $poaService->obtenerDatosPOA($filtrosPoa2);
    echo "   OK! Conceptos POA: " . count($poaResult2['dataPoa']) . "\n";
    echo "   Tiempo: " . round((microtime(true) - $start) * 1000, 2) . "ms\n\n";

    $start = microtime(true);
    $erService = app(IERDomainService::class);
    echo "4. Probando ERDomainService::obtenerDatosER() [Consolidado]...\n";
    $filtrosEr1 = FiltrosER::createFromRequest(['anio' => 2026]);
    $erResult1 = $erService->obtenerDatosER($filtrosEr1);
    echo "   OK! Conceptos ER: " . count($erResult1) . "\n";
    echo "   Tiempo: " . round((microtime(true) - $start) * 1000, 2) . "ms\n\n";

    echo "--- PRUEBA COMPLETADA CON ÉXITO SIN EXCEPCIONES ---\n";
    echo "Memoria máxima usada: " . round(memory_get_peak_usage() / 1024 / 1024, 2) . " MB\n";

} catch (\Exception $e) {
    echo "!!! ERROR CRÍTICO DETECTADO !!!\n";
    echo "Exception: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
} catch (\TypeError $e) {
    echo "!!! TYPE ERROR DETECTADO !!!\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
