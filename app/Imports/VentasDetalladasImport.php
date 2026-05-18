<?php

namespace App\Imports;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\ConceptoMaestro;
use App\Domain\Entities\RegistroFinanciero;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class VentasDetalladasImport
{
    private string $programa;
    private $todosAlmacenes;
    private $lineasCache = null;

    public function __construct(string $programa = 'PAR')
    {
        $this->programa = $programa;
        $this->todosAlmacenes = Almacen::all();
    }

    protected function getLineas()
    {
        if ($this->lineasCache === null) {
            $this->lineasCache = ConceptoMaestro::where('categoria', 'LINEA_PRODUCTO')->get();
        }
        return $this->lineasCache;
    }

    public function import(string $filePath)
    {
        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        
        $spreadsheet = $reader->load($filePath);
        $sheetNames = $spreadsheet->getSheetNames();
        
        $configHojas = [
            'PAR' => 'PAR',
            'ESP' => 'PE'
        ];

        $totalRegistros = 0;
        $anio = 2026;
        $now = now();
        $meses = [
            1 => 3, 2 => 4, 3 => 5, 4 => 7, 5 => 8, 6 => 9, 
            7 => 11, 8 => 12, 9 => 13, 10 => 15, 11 => 16, 12 => 17
        ];

        foreach ($configHojas as $nombreHoja => $programa) {
            if (!in_array($nombreHoja, $sheetNames)) continue;

            $sheet = $spreadsheet->getSheetByName($nombreHoja);
            $rows = $sheet->toArray();
            $almacenActual = null;
            $upsertData = [];

            foreach ($rows as $index => $row) {
                $col0 = trim((string)($row[0] ?? ''));
                $col1 = trim((string)($row[1] ?? ''));

                if ($almacenActual && $col1 !== '' && is_numeric($col1)) {
                    $lineaNumero = (int)$col1;
                    $lineaNombre = $col0;

                    $linea = $this->getLineas()->first(function($l) use ($lineaNumero, $lineaNombre) {
                        return $l->numero == $lineaNumero || strcasecmp($l->nombre, $lineaNombre) === 0;
                    });

                    if (!$linea) {
                        $linea = ConceptoMaestro::create([
                            'nombre' => $lineaNombre,
                            'categoria' => 'LINEA_PRODUCTO',
                            'numero' => $lineaNumero,
                            'orden' => 0
                        ]);
                        $this->lineasCache->push($linea);
                    }

                    foreach ($meses as $mes => $colIndex) {
                        $montoRaw = $row[$colIndex] ?? 0;
                        $montoLimpio = preg_replace('/[^\d.-]/', '', (string)$montoRaw);

                        if ($montoLimpio !== '' && is_numeric($montoLimpio)) {
                            $monto = (float) $montoLimpio;
                            if ($monto > 0) {
                                $upsertData[] = [
                                    'almacen_id' => $almacenActual->id,
                                    'concepto_id' => $linea->id,
                                    'mes' => $mes,
                                    'anio' => $anio,
                                    'monto' => $monto,
                                    'tipo_dato' => 'REAL',
                                    'programa' => $programa,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ];
                                $totalRegistros++;
                            }
                        }
                    }
                } else {
                    $nuevoAlmacen = $this->identificarAlmacenEnFila($col1) ?: $this->identificarAlmacenEnFila($col0);
                    if ($nuevoAlmacen) {
                        if ($almacenActual && $almacenActual->id !== $nuevoAlmacen->id) {
                            Log::info("[Ventas] Hoja $nombreHoja -> Cambio: {$almacenActual->nombre} → {$nuevoAlmacen->nombre} (fila $index)");
                        } elseif (!$almacenActual) {
                            Log::info("[Ventas] Hoja $nombreHoja -> Primer almacén: {$nuevoAlmacen->nombre} (fila $index)");
                        }
                        $almacenActual = $nuevoAlmacen;
                    }
                }
            }

            // Batch upsert cada 500 registros
            if (!empty($upsertData)) {
                // Deduplicar por unique key (almacen_id, concepto_id, mes, anio, tipo_dato, programa)
                $deduped = [];
                foreach ($upsertData as $row) {
                    $key = $row['almacen_id'] . '|' . $row['concepto_id'] . '|' . $row['mes'] . '|' . $row['anio'] . '|' . $row['tipo_dato'] . '|' . ($row['programa'] ?? '');
                    $deduped[$key] = $row;
                }
                $upsertData = array_values($deduped);
                Log::info("[Ventas] Hoja $nombreHoja: {$totalRegistros} registros, " . count($upsertData) . " únicos, ejecutando upsert por lotes...");
                foreach (array_chunk($upsertData, 500) as $chunk) {
                    RegistroFinanciero::upsert(
                        $chunk,
                        ['almacen_id', 'concepto_id', 'mes', 'anio', 'tipo_dato', 'programa'],
                        ['monto', 'updated_at']
                    );
                }
                Log::info("[Ventas] Hoja $nombreHoja: upsert completado.");
            }
        }

        $spreadsheet->disconnectWorksheets();
        return $totalRegistros;
    }

    protected function identificarAlmacenEnFila(string $texto): ?Almacen
    {
        if (empty($texto) || strlen($texto) < 4) return null;
        $textoNorm = strtoupper(trim(preg_replace('/[^\w\s]/u', '', $texto)));
        
        $blacklist = ['LINEA', 'TOTAL', 'PROGRAMA', 'ENERO', 'FEBRERO', 'MAIZ', 'FRIJOL', 'ABARROTES', 'LECHE'];
        foreach ($blacklist as $word) {
            if (str_contains($textoNorm, $word)) return null;
        }

        $textoNorm = \App\Domain\Shared\StoreNameNormalizer::normalize($textoNorm);

        foreach ($this->todosAlmacenes as $almacen) {
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
