<?php
require 'vendor/autoload.php';
use Maatwebsite\Excel\Facades\Excel;

$path = '../../PT FORMATO 01 2026 (PROFORMA)_CONSOLIDADO.xlsx';

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $sheets = Excel::toArray(new \stdClass(), $path);
    
    foreach ($sheets as $index => $rows) {
        $name = $rows[4][3] ?? 'N/A';
        $uo = $rows[3][3] ?? 'N/A';
        echo "Sheet $index | UO: $uo | Almacen: $name\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
