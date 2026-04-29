<?php
require 'vendor/autoload.php';
use App\Domain\Services\PDFERExtractorService;

$path = 'C:/Users/qange/Downloads/01Enero.pdf';
$anio = 2026;

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $service = new PDFERExtractorService();
    $result = $service->extract($path, $anio);
    echo "OK: PDF migrado a $anio para " . $result['count'] . " registros.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
