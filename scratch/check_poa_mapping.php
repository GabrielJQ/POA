<?php
require 'vendor/autoload.php';
use App\Models\ConceptoMaestro;

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $conceptos = ConceptoMaestro::where('categoria', 'POA')
        ->where(function($q) {
            $q->where('nombre', 'ilike', '%DISTRIBUCION%')
              ->orWhere('nombre', 'ilike', '%RESULTADO%');
        })
        ->get(['nombre', 'concepto_er_nombre']);

    echo "POA CONCEPTS MAPPING:\n";
    foreach ($conceptos as $c) {
        echo "- POA: {$c->nombre} -> ER: {$c->concepto_er_nombre}\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
