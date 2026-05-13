<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class MermasQuebrantosImport
{
    private array $mapeoHojas = [
        'PT AYUTLA' => 'AYUTLA MIXES',
        'PT CHILAR' => 'SAN JOSE EL CHILAR',
        'PT CUAJIMOLOYAS' => 'CUAJIMOLOYAS',
        'PT IXTLAN' => 'IXTLAN DE JUAREZ',
        'PT JUCHATENGO' => 'SAN PEDRO JUCHATENGO',
        'PT LACHIXIO' => 'LACHIXIO',
        'PT MATATLAN' => 'SANTIAGO MATATLAN',
        'PT MAGDALENA OCOTLAN' => 'MAGDALENA OCOTLAN',
        'PT SAN ANDRES' => 'SAN ANDRES HIDALGO',
        'PT TAMAZULAPAN' => 'TAMAZULAPAN',
        'PT TEOTITLAN' => 'SANTIAGO TEOTITLAN',
        'PT VALLES' => 'ALMACEN CENTRAL OAXACA',
    ];

    private ?int $conceptoId = null;
    private array $cacheAlmacenes = [];
    private array $porcentajes;

    public function __construct()
    {
        $this->porcentajes = config('mermas.lineas', []);
        $concepto = ConceptoMaestro::where('nombre', 'MERMAS, QUEBRANTOS Y MAL ESTADO')
            ->where('categoria', 'POA')
            ->first();
        $this->conceptoId = $concepto?->id;
    }

    public function import(string $filePath, int $anio): int
    {
        if (!$this->conceptoId) {
            throw new Exception('Concepto MERMAS, QUEBRANTOS Y MAL ESTADO no encontrado en la base de datos.');
        }

        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);

        $count = 0;

        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            if ($sheetName === 'PT 2') continue;

            $nombreAlmacen = $this->mapeoHojas[$sheetName] ?? null;
            if (!$nombreAlmacen) continue;

            $almacen = $this->findAlmacen($nombreAlmacen);
            if (!$almacen) continue;

            $sheet = $spreadsheet->getSheetByName($sheetName);
            $rows = $sheet->toArray();

            $totalesMensuales = array_fill(1, 12, 0.0);

            // PROGRAMA ABASTO RURAL: rows 15-22 (1-indexed) = indices 14-21 (0-indexed)
            for ($i = 14; $i <= 21; $i++) {
                if (!isset($rows[$i])) continue;

                $nombreLinea = trim((string) ($rows[$i][0] ?? ''));
                if (empty($nombreLinea)) continue;

                $porcentajes = $this->porcentajes[$nombreLinea] ?? null;
                if (!$porcentajes) continue;

                $tasaMerma = (float) ($porcentajes['merma'] ?? 0);
                $tasaQuebranto = (float) ($porcentajes['quebranto'] ?? 0);
                $tasaTotal = ($tasaMerma + $tasaQuebranto) / 100;

                if ($tasaTotal <= 0) continue;

                // Columnas $ por mes: col E(4)=ENERO, G(6)=FEBRERO, ..., col AA(26)=DICIEMBRE
                for ($mes = 1; $mes <= 12; $mes++) {
                    $colIdx = ($mes - 1) * 2 + 4;
                    $montoVenta = $this->parseMonto($rows[$i][$colIdx] ?? null);
                    if ($montoVenta === null || $montoVenta <= 0) continue;

                    $totalesMensuales[$mes] += $montoVenta * $tasaTotal;
                }
            }

            for ($mes = 1; $mes <= 12; $mes++) {
                if ($totalesMensuales[$mes] <= 0) continue;

                RegistroFinanciero::updateOrCreate(
                    [
                        'almacen_id' => $almacen->id,
                        'concepto_id' => $this->conceptoId,
                        'anio' => $anio,
                        'mes' => $mes,
                        'tipo_dato' => 'META',
                        'programa' => null,
                    ],
                    ['monto' => round($totalesMensuales[$mes], 2)]
                );
                $count++;
            }
        }

        $spreadsheet->disconnectWorksheets();
        return $count;
    }

    private function findAlmacen(string $nombre): ?Almacen
    {
        if (isset($this->cacheAlmacenes[$nombre])) {
            return $this->cacheAlmacenes[$nombre];
        }

        $almacen = Almacen::where('nombre', $nombre)->first();
        $this->cacheAlmacenes[$nombre] = $almacen;
        return $almacen;
    }

    private function parseMonto($valor): ?float
    {
        if ($valor === null || $valor === '') return null;

        if (is_numeric($valor)) {
            $num = (float) $valor;
            return $num > 0 ? $num : null;
        }

        $limpio = str_replace(',', '', trim((string) $valor));
        $limpio = preg_replace('/[^\d.-]/', '', $limpio);

        if (!is_numeric($limpio)) return null;
        $num = (float) $limpio;
        return $num > 0 ? $num : null;
    }
}
