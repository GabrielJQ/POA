<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

$pdfPath = 'C:\Users\qange\Downloads\01Enero.pdf';
$parser = new Parser();
$pdf = $parser->parseFile($pdfPath);
$text = $pdf->getText();

echo "--- TEXT START ---\n";
echo $text;
echo "\n--- TEXT END ---\n";

$lineas = explode("\n", $text);
foreach ($lineas as $linea) {
    if (stripos($linea, 'TOTAL GASTOS DE DISTRIBUCION') !== false || stripos($linea, 'RESULTADO DIRECTO DE OPERACION') !== false) {
        echo "\nMATCH FOUND: " . $linea . "\n";
        $lineaSoloNumeros = preg_replace('/^.*[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,}\s+/', '', $linea);
        echo "SOLO NUMEROS: " . $lineaSoloNumeros . "\n";
        preg_match_all('/-?\d{1,3}(?:,\d{3})*(?:\.\d+)?/', $lineaSoloNumeros, $matches);
        print_r($matches[0]);
    }
}
