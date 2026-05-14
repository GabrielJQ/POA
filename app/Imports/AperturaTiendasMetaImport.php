<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class AperturaTiendasMetaImport
{
    private array $mapeoAlmacenes = [
        'AYUTLA MIXE'               => 'AYUTLA MIXES',
        'SN ANDRES HIDALGO.'        => 'SAN ANDRES HIDALGO',
        'EL CHILAR'                 => 'SAN JOSE EL CHILAR',
        'JUCHATENGO'                => 'SAN PEDRO JUCHATENGO',
        'SANTA MARIA LACHIXIO'      => 'LACHIXIO',
        'TAMAZULAPAM'               => 'TAMAZULAPAN',
        'TEOTITLAN DE FLORES MAGON' => 'SANTIAGO TEOTITLAN',
        'SANTO TOMAS TAMAZULAPAN'   => 'TAMAZULAPAN',
    ];

    private array $conceptos;
    private array $cacheAlmacenes = [];

    public function __construct()
    {
        $this->conceptos = [
            'TOTAL'       => 33, // APERTURA DE TIENDAS
            'OBJETIVO'    => 34, // APERTURA DE TIENDAS LOCALIDAD OBJETIVO
            'ESTRATEGICA' => 35, // APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA
        ];
    }

    public function import(string $filePath, int $anio): int
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheets = $spreadsheet->getSheetNames();
        $count = 0;

        foreach ($sheets as $sheetName) {
            if ($sheetName === 'PT 4') continue; 

            $sheet = $spreadsheet->getSheetByName($sheetName);
            
            $almacenName = '';
            for ($i = 1; $i <= 10; $i++) {
                $val = $sheet->getCell("A$i")->getValue();
                if (stripos((string)$val, 'ALMACÉN') !== false) {
                    $almacenName = trim($sheet->getCell("D$i")->getValue());
                    break;
                }
            }
            if (!$almacenName) $almacenName = $sheetName;

            $almacen = $this->findAlmacen($almacenName);
            if (!$almacen) continue;

            $dataRows = $sheet->toArray();
            $monthlyTotals = []; 

            for ($rowIdx = 11; $rowIdx < count($dataRows); $rowIdx++) {
                $row = $dataRows[$rowIdx];
                $firstCell = trim((string)($row[0] ?? ''));
                if (stripos($firstCell, 'TOTAL') !== false || empty(array_filter($row))) {
                    if (stripos($firstCell, 'TOTAL') !== false) break;
                    continue;
                }

                $esObjetivo = !empty(trim((string)($row[9] ?? '')));
                $esEstrategica = !empty(trim((string)($row[10] ?? '')));

                for ($m = 1; $m <= 12; $m++) {
                    $colIdx = 10 + $m; 
                    $cellValue = $row[$colIdx] ?? null;

                    if ($cellValue !== null && $cellValue !== '') {
                        $monthlyTotals[$m][$this->conceptos['TOTAL']] = ($monthlyTotals[$m][$this->conceptos['TOTAL']] ?? 0) + 1;
                        
                        if ($esObjetivo) {
                            $monthlyTotals[$m][$this->conceptos['OBJETIVO']] = ($monthlyTotals[$m][$this->conceptos['OBJETIVO']] ?? 0) + 1;
                        }
                        if ($esEstrategica) {
                            $monthlyTotals[$m][$this->conceptos['ESTRATEGICA']] = ($monthlyTotals[$m][$this->conceptos['ESTRATEGICA']] ?? 0) + 1;
                        }
                    }
                }
            }

            foreach ($monthlyTotals as $mes => $concepts) {
                foreach ($concepts as $conceptoId => $monto) {
                    RegistroFinanciero::updateOrCreate(
                        [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $conceptoId,
                            'anio' => $anio,
                            'mes' => $mes,
                            'tipo_dato' => 'META',
                        ],
                        ['monto' => $monto]
                    );
                    $count++;
                }
            }
        }

        $spreadsheet->disconnectWorksheets();
        return $count;
    }

    private function findAlmacen(string $nombreExcel): ?Almacen
    {
        $nombreExcel = mb_strtoupper(trim($nombreExcel));

        if (isset($this->cacheAlmacenes[$nombreExcel])) {
            return $this->cacheAlmacenes[$nombreExcel];
        }

        $nombreLimpio = str_replace('PT ', '', $nombreExcel);
        $nombreDB = $this->mapeoAlmacenes[$nombreLimpio] ?? $this->mapeoAlmacenes[$nombreExcel] ?? $nombreLimpio;
        
        $almacen = Almacen::where('nombre', $nombreDB)
            ->orWhere('nombre', 'LIKE', "%$nombreDB%")
            ->first();

        $this->cacheAlmacenes[$nombreExcel] = $almacen;
        return $almacen;
    }
}
