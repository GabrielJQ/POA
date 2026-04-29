<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$path = '../../PT FORMATO 01 2026 (PROFORMA)_CONSOLIDADO.xlsx';

try {
    $reader = IOFactory::createReaderForFile($path);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($path);
    $sheetNames = $spreadsheet->getSheetNames();
    echo "SHEET NAMES:\n";
    foreach ($sheetNames as $index => $name) {
        echo "$index: $name\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
