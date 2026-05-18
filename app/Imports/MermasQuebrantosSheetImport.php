<?php

namespace App\Imports;

use App\Domain\Shared\StoreNameNormalizer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MermasQuebrantosSheetImport implements ToCollection
{
    private array $upsertData = [];

    public function __construct(
        private int $anio,
        private ?int $conceptoId,
        private array $porcentajes,
        private array $almacenes,
        private string $sheetName
    ) {}

    public function collection(Collection $rows): void
    {
        if (!$this->conceptoId) return;

        $nombreAlmacen = StoreNameNormalizer::normalize($this->sheetName);
        $almacen = $this->almacenes[$nombreAlmacen] ?? null;
        if (!$almacen) return;

        $totalesMensuales = array_fill(1, 12, 0.0);

        for ($i = 14; $i <= 21; $i++) {
            if (!isset($rows[$i])) continue;

            $nombreLinea = trim((string)($rows[$i][0] ?? ''));
            if (empty($nombreLinea)) continue;

            $lineaPorcentajes = $this->porcentajes[$nombreLinea] ?? null;
            if (!$lineaPorcentajes) continue;

            $tasaMerma = (float)($lineaPorcentajes['merma'] ?? 0);
            $tasaQuebranto = (float)($lineaPorcentajes['quebranto'] ?? 0);
            $tasaTotal = ($tasaMerma + $tasaQuebranto) / 100;

            if ($tasaTotal <= 0) continue;

            for ($mes = 1; $mes <= 12; $mes++) {
                $colIdx = ($mes - 1) * 2 + 4;
                $montoVenta = $this->parseMonto($rows[$i][$colIdx] ?? null);
                if ($montoVenta === null || $montoVenta <= 0) continue;

                $totalesMensuales[$mes] += $montoVenta * $tasaTotal;
            }
        }

        for ($mes = 1; $mes <= 12; $mes++) {
            if ($totalesMensuales[$mes] <= 0) continue;

            $this->upsertData[] = [
                'almacen_id' => $almacen->id,
                'concepto_id' => $this->conceptoId,
                'anio' => $this->anio,
                'mes' => $mes,
                'tipo_dato' => 'META',
                'programa' => null,
                'monto' => round($totalesMensuales[$mes], 2),
            ];
        }
    }

    public function getUpsertData(): array
    {
        return $this->upsertData;
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
