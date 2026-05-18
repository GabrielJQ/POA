<?php

namespace App\Imports;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Shared\StoreNameNormalizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class VentasDetalladasSheetImport implements ToCollection
{
    private Collection $tmAlmacenes;
    private Collection $lineas;
    private array $upsertData = [];
    private array $columnasMes = [
        1 => 3, 2 => 4, 3 => 5, 4 => 7, 5 => 8, 6 => 9,
        7 => 11, 8 => 12, 9 => 13, 10 => 15, 11 => 16, 12 => 17,
    ];

    public function __construct(
        private int $anio,
        private string $programa,
        IAlmacenRepository $almacenRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        Collection $lineas
    ) {
        $this->tmAlmacenes = $almacenRepo->findAllOrdered()->keyBy('id');
        $this->lineas = $lineas->map(fn($v) => is_object($v) ? $v->id : $v);
    }

    public function collection(Collection $rows): void
    {
        $almacenActual = null;
        $now = now();

        foreach ($rows as $index => $row) {
            $col0 = trim((string)($row[0] ?? ''));
            $col1 = trim((string)($row[1] ?? ''));

            if ($almacenActual && $col1 !== '' && is_numeric($col1)) {
                $lineaNumero = (int)$col1;
                $lineaNombre = $col0;

                $lineaId = $this->lineas->get($lineaNumero);

                if (!$lineaId) {
                    $lineaConcepto = $this->conceptoRepo->findByName($lineaNombre, 'LINEA_PRODUCTO');
                    if (!$lineaConcepto) {
                        Log::warning("[VentasDetalladas] Línea de producto no encontrada y se omite: '{$lineaNombre}' (num: {$lineaNumero}) en hoja {$this->programa}");
                        continue;
                    }
                    $lineaId = $lineaConcepto->id;
                    $this->lineas->put($lineaNumero, $lineaId);
                }

                foreach ($this->columnasMes as $mes => $colIndex) {
                    $montoRaw = $row[$colIndex] ?? 0;
                    $montoLimpio = preg_replace('/[^\d.-]/', '', (string)$montoRaw);

                    if ($montoLimpio !== '' && is_numeric($montoLimpio)) {
                        $monto = (float)$montoLimpio;
                        if ($monto > 0) {
                            $this->upsertData[] = [
                                'almacen_id' => $almacenActual->id,
                                'concepto_id' => $lineaId,
                                'mes' => $mes,
                                'anio' => $this->anio,
                                'monto' => $monto,
                                'tipo_dato' => 'REAL',
                                'programa' => $this->programa,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            } else {
                $nuevoAlmacen = $this->identificarAlmacen($col1) ?? $this->identificarAlmacen($col0);
                if ($nuevoAlmacen) {
                    $almacenActual = $nuevoAlmacen;
                }
            }
        }
    }

    public function getUpsertData(): array
    {
        $deduped = [];
        foreach ($this->upsertData as $row) {
            $key = $row['almacen_id'] . '|' . $row['concepto_id'] . '|' . $row['mes'] . '|' . $row['anio'] . '|' . $row['tipo_dato'] . '|' . ($row['programa'] ?? '');
            $deduped[$key] = $row;
        }
        return array_values($deduped);
    }

    private function identificarAlmacen(string $texto): ?object
    {
        if (empty($texto) || strlen($texto) < 4) return null;

        $textoNorm = strtoupper(trim(preg_replace('/[^\w\s]/u', '', $texto)));

        $blacklist = ['LINEA', 'TOTAL', 'PROGRAMA', 'ENERO', 'FEBRERO', 'MAIZ', 'FRIJOL', 'ABARROTES', 'LECHE'];
        foreach ($blacklist as $word) {
            if (str_contains($textoNorm, $word)) return null;
        }

        $textoNorm = StoreNameNormalizer::normalize($textoNorm);

        foreach ($this->tmAlmacenes as $almacen) {
            $nombreAlmNorm = strtoupper(trim(preg_replace('/[^\w\s]/u', '', $almacen->nombre)));
            if (str_contains($textoNorm, $nombreAlmNorm) || str_contains($nombreAlmNorm, $textoNorm)) return $almacen;

            $palabrasAlmacen = explode(' ', $nombreAlmNorm);
            $palabrasIgnorar = ['ALMACEN', 'RURAL', 'CENTRAL', 'SUCURSAL', 'UNIDAD', 'VALLES', 'SANTIAGO', 'DE', 'DEL', 'LAS', 'LOS', 'SAN'];
            foreach ($palabrasAlmacen as $palabra) {
                if (strlen($palabra) > 3 && !in_array($palabra, $palabrasIgnorar) && str_contains($textoNorm, $palabra)) return $almacen;
            }
        }

        return null;
    }
}
