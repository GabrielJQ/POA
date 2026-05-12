<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Models\UnidadOperativa;
use App\Models\Regional;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ERSheetImport
{
    protected $anio;
    protected $sheetName;
    protected $conceptosCache = null;
    protected $conceptosNormalizadosCache = null;

    public function __construct($anio, $sheetName = '')
    {
        $this->anio = $anio;
        $this->sheetName = $sheetName;
    }

    protected function normalizarNombre(string $nombre): string
    {
        $nombre = trim($nombre);
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        $nombre = mb_strtoupper($nombre, 'UTF-8');
        return $nombre;
    }

    protected function getConceptos()
    {
        if ($this->conceptosCache === null) {
            $this->conceptosCache = ConceptoMaestro::where('categoria', 'ER')->get();
        }
        return $this->conceptosCache;
    }

    protected function getConceptosNormalizados()
    {
        if ($this->conceptosNormalizadosCache === null) {
            $this->conceptosNormalizadosCache = $this->getConceptos()->map(function ($c) {
                return (object)[
                    'id' => $c->id,
                    'nombreNorm' => $this->normalizarNombre($c->nombre),
                    'conceptoErNorm' => $c->concepto_er_nombre
                        ? $this->normalizarNombre($c->concepto_er_nombre)
                        : null,
                ];
            });
        }
        return $this->conceptosNormalizadosCache;
    }

    public function import(array $rows)
    {
        // 1. Identificar Almacén y Unidad Operativa
        $unidadOperativaNombre = trim($rows[3][3] ?? '');
        $almacenNombreInterno = trim($rows[4][3] ?? '');
        
        $almacen = null;

        // PRIORIDAD 1: Usar nombre de pestaña (ej: " PT AYUTLA" → "AYUTLA" → "AYUTLA MIXES")
        $pestañaLimpia = trim(preg_replace(
            ['/^\s*PT\s+/i', '/\s+PROFORMA\s*$/i', '/\s+CONSOLIDADO\s*$/i', '/\s*\([^)]*\)\s*/'],
            ['', '', '', ''],
            $this->sheetName
        ));
        $pestañaLimpia = trim($pestañaLimpia);

        // Casos especiales: hojas que mapean a ALMACEN CENTRAL OAXACA
        $pestañaLower = mb_strtolower($pestañaLimpia);
        if ($pestañaLimpia === '1' || $pestañaLower === 'valles' || $pestañaLower === 'valles centrales') {
            $almacen = Almacen::find(1);
        }

        if (!$almacen && strlen($pestañaLimpia) > 3) {
            $almacen = Almacen::where('nombre', 'ilike', '%' . $pestañaLimpia . '%')->first();
        }

        // PRIORIDAD 2: Usar D5 como respaldo si la pestaña no dio resultado
        if (!$almacen && !empty($almacenNombreInterno) && $almacenNombreInterno !== 'N/A') {
            $almacen = Almacen::where('nombre', 'ilike', $almacenNombreInterno)->first();
            if (!$almacen) {
                $almacen = Almacen::where('nombre', 'ilike', '%' . $almacenNombreInterno . '%')->first();
            }
        }

        if (!$almacen) {
            Log::warning("[ERSheetImport] Almacén NO encontrado para hoja '{$this->sheetName}' (limpio: '{$pestañaLimpia}', interno: '{$almacenNombreInterno}') — se omite.");
            return 0;
        }

        Log::info("[ERSheetImport] Hoja '{$this->sheetName}' → almacén: {$almacen->nombre} (id: {$almacen->id})");

        if (empty($unidadOperativaNombre)) $unidadOperativaNombre = 'OAXACA VALLES CENTRALES';

        DB::beginTransaction();
        try {
            $regional = Regional::firstOrCreate(['nombre' => 'REGIONAL OAXACA']);

            $unidadOperativa = UnidadOperativa::where('nombre', 'ilike', $unidadOperativaNombre)->first();
            if (!$unidadOperativa) {
                $unidadOperativa = UnidadOperativa::first();
            }

            $upsertData = [];
            $now = now();
            $registrosGuardados = 0;

            // Procesar filas (el contenido real empieza después de la fila 12)
            for ($i = 12; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // Buscar el nombre del concepto en las primeras 3 columnas
                $conceptoNombre = trim($row[0] ?? $row[1] ?? $row[2] ?? '');
                
                if (empty($conceptoNombre)) continue;

                $conceptoMayus = mb_strtoupper($conceptoNombre, 'UTF-8');
                if (str_contains($conceptoMayus, 'ELABORÓ') || str_contains($conceptoMayus, 'ELABORO')) break;

                $conceptoNormInput = $this->normalizarNombre($conceptoNombre);
                $conceptoMatch = $this->getConceptosNormalizados()->first(function($c) use ($conceptoNormInput) {
                    return $c->nombreNorm === $conceptoNormInput ||
                           ($c->conceptoErNorm && $c->conceptoErNorm === $conceptoNormInput);
                });
                $concepto = $conceptoMatch ? $this->getConceptos()->firstWhere('id', $conceptoMatch->id) : null;
                if (!$concepto) {
                    Log::debug("[ERSheetImport] Concepto no encontrado: '{$conceptoNombre}' (normalizado: '{$conceptoNormInput}') en hoja '{$this->sheetName}'");
                    continue;
                }

                // Columnas de meses (Enero en D = index 3)
                for ($mes = 1; $mes <= 12; $mes++) {
                    $montoRaw = $row[2 + $mes] ?? null; 
                    
                    if ($montoRaw === null || $montoRaw === '') continue;
                    
                    $montoLimpio = preg_replace('/[^\d.-]/', '', (string)$montoRaw);
                    if ($montoLimpio === '' || !is_numeric($montoLimpio)) continue;
                    
                    $monto = (float)$montoLimpio;
                    
                    if ($monto != 0) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $concepto->id,
                            'anio' => $this->anio,
                            'mes' => $mes,
                            'monto' => $monto,
                            'tipo_dato' => 'META',
                            'programa' => null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $registrosGuardados++;
                    }
                }
            }

            if (!empty($upsertData)) {
                // Deduplicar por unique key
                $deduped = [];
                foreach ($upsertData as $row) {
                    $key = $row['almacen_id'] . '|' . $row['concepto_id'] . '|' . $row['mes'] . '|' . $row['anio'] . '|' . $row['tipo_dato'] . '|' . ($row['programa'] ?? '');
                    $deduped[$key] = $row;
                }
                $upsertData = array_values($deduped);
                Log::info("[ERSheetImport] {$almacen->nombre}: {$registrosGuardados} registros preparados, " . count($upsertData) . " únicos, ejecutando upsert...");
                foreach (array_chunk($upsertData, 500) as $chunk) {
                    RegistroFinanciero::upsert(
                        $chunk,
                        ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                        ['monto', 'updated_at']
                    );
                }
                Log::info("[ERSheetImport] {$almacen->nombre}: upsert completado ({$registrosGuardados} registros).");
            } else {
                Log::info("[ERSheetImport] {$almacen->nombre}: 0 registros (sin datos válidos).");
            }

            DB::commit();
            return $registrosGuardados;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
