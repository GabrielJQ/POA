<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class SurtimientoTiendasImport
{
    private array $mapeoAlmacenes = [
        'AYUTLA MIXE'        => 'AYUTLA MIXES',
        'SN ANDRES HIDALGO.' => 'SAN ANDRES HIDALGO',
        'EL CHILAR'          => 'SAN JOSE EL CHILAR',
        'JUCHATENGO'         => 'SAN PEDRO JUCHATENGO',
        'SANTA MA. LACHIXIO' => 'LACHIXIO',
        'TAMAZULAPAM'        => 'TAMAZULAPAN',
        'TEOTITLAN DE F.M.'  => 'SANTIAGO TEOTITLAN',
    ];

    private array $conceptos;
    private array $cacheAlmacenes = [];

    public function __construct()
    {
        $this->conceptos = [
            'OPORTUNIDAD' => ConceptoMaestro::where('nombre', 'OPORTUNIDAD DE SURTIMIENTO A TIENDAS')
                ->where('categoria', 'POA')->first()?->id,
            'EFICIENCIA' => ConceptoMaestro::where('nombre', 'EFICIENCIA DE SURTIMIENTO A TIENDAS')
                ->where('categoria', 'POA')->first()?->id,
        ];
    }

    public function import(string $filePath, int $anio): int
    {
        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Columnas: A=almacen, B=OportunidadQ1, C=EficienciaQ1,
        //           D=OportunidadQ2, E=EficienciaQ2,
        //           F=OportunidadQ3, G=EficienciaQ3,
        //           H=OportunidadQ4, I=EficienciaQ4
        $trimestres = [
            1 => ['op' => 1, 'ef' => 2, 'meses' => [1, 2, 3]],
            2 => ['op' => 3, 'ef' => 4, 'meses' => [4, 5, 6]],
            3 => ['op' => 5, 'ef' => 6, 'meses' => [7, 8, 9]],
            4 => ['op' => 7, 'ef' => 8, 'meses' => [10, 11, 12]],
        ];

        $count = 0;
        $upsertData = [];

        foreach ($rows as $rowNum => $row) {
            if ($rowNum < 5) continue;
            $nombreExcel = trim($row[0] ?? '');
            if (empty($nombreExcel) || stripos($nombreExcel, 'TOTAL') !== false) continue;

            $almacen = $this->findAlmacen($nombreExcel);
            if (!$almacen) continue;

            foreach ($trimestres as $trimestreNum => $t) {
                $valorOportunidad = $this->parseValor($row[$t['op']] ?? null);
                $valorEficiencia = $this->parseValor($row[$t['ef']] ?? null);

                if ($valorOportunidad !== null && $this->conceptos['OPORTUNIDAD']) {
                    foreach ($t['meses'] as $mes) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $this->conceptos['OPORTUNIDAD'],
                            'anio' => $anio,
                            'mes' => $mes,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                            'monto' => $valorOportunidad / 3
                        ];
                        $count++;
                    }
                }
                if ($valorEficiencia !== null && $this->conceptos['EFICIENCIA']) {
                    foreach ($t['meses'] as $mes) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $this->conceptos['EFICIENCIA'],
                            'anio' => $anio,
                            'mes' => $mes,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                            'monto' => $valorEficiencia / 3
                        ];
                        $count++;
                    }
                }
            }
        }

        if (!empty($upsertData)) {
            $chunks = array_chunk($upsertData, 1000);
            foreach ($chunks as $chunk) {
                RegistroFinanciero::upsert(
                    $chunk,
                    ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                    ['monto']
                );
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

        $nombreDB = $this->mapeoAlmacenes[$nombreExcel] ?? $nombreExcel;
        $almacen = Almacen::where('nombre', $nombreDB)->first();
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
