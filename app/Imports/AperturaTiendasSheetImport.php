<?php

namespace App\Imports;

use App\Domain\Shared\StoreNameNormalizer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AperturaTiendasSheetImport implements ToCollection
{
    private array $upsertData = [];

    public function __construct(
        private int $anio,
        private array $conceptos,
        private array $almacenes,
        private string $sheetName
    ) {}

    public function collection(Collection $rows): void
    {
        $almacenName = '';
        foreach ($rows->slice(0, 10) as $i => $row) {
            $val = trim((string)($row[0] ?? ''));
            if (stripos($val, 'ALMACÉN') !== false) {
                $almacenName = trim((string)($row[3] ?? ''));
                break;
            }
        }
        if (!$almacenName) $almacenName = $this->sheetName;

        $almacen = $this->findAlmacen($almacenName);
        if (!$almacen) return;

        $monthlyTotals = [];

        $rowsData = $rows->slice(11);

        foreach ($rowsData as $row) {
            $firstCell = trim((string)($row[0] ?? ''));
            if (stripos($firstCell, 'TOTAL') !== false) break;
            if (empty(array_filter($row))) continue;

            $esObjetivo = !empty(trim((string)($row[9] ?? '')));
            $esEstrategica = !empty(trim((string)($row[10] ?? '')));

            for ($m = 1; $m <= 12; $m++) {
                $colIdx = 10 + $m;
                $cellValue = $row[$colIdx] ?? null;

                if ($cellValue !== null && $cellValue !== '') {
                    $monthlyTotals[$m][$this->conceptos['TOTAL']] = ($monthlyTotals[$m][$this->conceptos['TOTAL']] ?? 0) + 1;

                    if ($esObjetivo && $this->conceptos['OBJETIVO']) {
                        $monthlyTotals[$m][$this->conceptos['OBJETIVO']] = ($monthlyTotals[$m][$this->conceptos['OBJETIVO']] ?? 0) + 1;
                    }
                    if ($esEstrategica && $this->conceptos['ESTRATEGICA']) {
                        $monthlyTotals[$m][$this->conceptos['ESTRATEGICA']] = ($monthlyTotals[$m][$this->conceptos['ESTRATEGICA']] ?? 0) + 1;
                    }
                }
            }
        }

        foreach ($monthlyTotals as $mes => $concepts) {
            foreach ($concepts as $conceptoId => $monto) {
                $this->upsertData[] = [
                    'almacen_id' => $almacen->id,
                    'concepto_id' => $conceptoId,
                    'anio' => $this->anio,
                    'mes' => $mes,
                    'tipo_dato' => 'META',
                    'programa' => null,
                    'monto' => $monto,
                ];
            }
        }
    }

    public function getUpsertData(): array
    {
        return $this->upsertData;
    }

    private function findAlmacen(string $nombreExcel): ?object
    {
        $nombreExcel = mb_strtoupper(trim($nombreExcel));
        $nombreDB = StoreNameNormalizer::normalize($nombreExcel);
        return $this->almacenes[$nombreDB] ?? null;
    }
}
