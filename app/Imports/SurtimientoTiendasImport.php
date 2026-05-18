<?php

namespace App\Imports;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Shared\StoreNameNormalizer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SurtimientoTiendasImport implements ToCollection
{
    private array $upsertData = [];
    private Collection $almacenes;
    private array $conceptos;
    private array $cacheAlmacenes = [];

    public function __construct(
        private int $anio,
        IAlmacenRepository $almacenRepo,
        IConceptoMaestroRepository $conceptoRepo
    ) {
        $this->almacenes = $almacenRepo->findAllOrdered()->keyBy('nombre');

        $opId = $conceptoRepo->findByName('OPORTUNIDAD DE SURTIMIENTO A TIENDAS', 'POA')?->id;
        $efId = $conceptoRepo->findByName('EFICIENCIA DE SURTIMIENTO A TIENDAS', 'POA')?->id;

        $this->conceptos = [
            'OPORTUNIDAD' => $opId,
            'EFICIENCIA' => $efId,
        ];
    }

    public function collection(Collection $rows): void
    {
        $trimestres = [
            1 => ['op' => 1, 'ef' => 2, 'meses' => [1, 2, 3]],
            2 => ['op' => 3, 'ef' => 4, 'meses' => [4, 5, 6]],
            3 => ['op' => 5, 'ef' => 6, 'meses' => [7, 8, 9]],
            4 => ['op' => 7, 'ef' => 8, 'meses' => [10, 11, 12]],
        ];

        foreach ($rows as $rowNum => $row) {
            if ($rowNum < 5) continue;

            $nombreExcel = trim((string)($row[0] ?? ''));
            if (empty($nombreExcel) || stripos($nombreExcel, 'TOTAL') !== false) continue;

            $almacen = $this->findAlmacen($nombreExcel);
            if (!$almacen) continue;

            foreach ($trimestres as $t) {
                $valorOportunidad = $this->parseValor($row[$t['op']] ?? null);
                $valorEficiencia = $this->parseValor($row[$t['ef']] ?? null);

                if ($valorOportunidad !== null && $this->conceptos['OPORTUNIDAD']) {
                    foreach ($t['meses'] as $mes) {
                        $this->upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $this->conceptos['OPORTUNIDAD'],
                            'anio' => $this->anio,
                            'mes' => $mes,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                            'monto' => $valorOportunidad / 3,
                        ];
                    }
                }

                if ($valorEficiencia !== null && $this->conceptos['EFICIENCIA']) {
                    foreach ($t['meses'] as $mes) {
                        $this->upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $this->conceptos['EFICIENCIA'],
                            'anio' => $this->anio,
                            'mes' => $mes,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                            'monto' => $valorEficiencia / 3,
                        ];
                    }
                }
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

        if (isset($this->cacheAlmacenes[$nombreExcel])) {
            return $this->cacheAlmacenes[$nombreExcel];
        }

        $nombreDB = StoreNameNormalizer::normalize($nombreExcel);
        $almacen = $this->almacenes->get($nombreDB);
        $this->cacheAlmacenes[$nombreExcel] = $almacen;
        return $almacen;
    }

    private function parseValor($valor): ?float
    {
        if ($valor === null || $valor === '') return null;
        $limpio = str_replace(',', '.', trim((string) $valor));
        $limpio = preg_replace('/[^\d.-]/', '', $limpio);
        if (!is_numeric($limpio)) return null;
        $num = (float) $limpio;
        if ($num == 0) return null;
        return $num;
    }
}
