<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Models\UnidadOperativa;
use App\Models\Regional;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exception;

class ERSheetImport
{
    protected $anio;
    protected $sheetName;

    public function __construct($anio, $sheetName = '')
    {
        $this->anio = $anio;
        $this->sheetName = $sheetName;
    }

    public function import(array $rows)
    {
        // 1. Identificar Almacén y Unidad Operativa
        $unidadOperativaNombre = trim($rows[3][3] ?? '');
        $almacenNombreInterno = trim($rows[4][3] ?? '');
        
        // Intentamos limpiar el nombre de la pestaña (ej: "PT AYUTLA" -> "AYUTLA")
        $pestañaLimpia = trim(str_ireplace(['PT', 'PROFORMA', 'TRABAJO', ' '], '', $this->sheetName));

        // NUEVA PRIORIDAD:
        // 1. Ver si el nombre de la pestaña coincide con algo oficial (más fiable en plantillas)
        $almacen = null;
        if (!empty($pestañaLimpia)) {
            $almacen = Almacen::where('nombre', 'ilike', '%' . $pestañaLimpia . '%')->first();
        }

        // 2. Si no, ver si el nombre interno (D5) existe en nuestra DB oficial
        if (!$almacen && !empty($almacenNombreInterno)) {
            $almacen = Almacen::where('nombre', 'ilike', $almacenNombreInterno)->first();
            
            // 3. Si aún no, búsqueda parcial del nombre interno
            if (!$almacen) {
                $almacen = Almacen::where('nombre', 'ilike', '%' . $almacenNombreInterno . '%')->first();
            }
        }

        // Si después de todo no hay almacén, esta hoja probablemente no es un detalle de almacén
        if (!$almacen) {
            return 0; 
        }

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

                // Buscar concepto maestro de categoría ER
                $concepto = ConceptoMaestro::where('categoria', 'ER')
                    ->where(function($q) use ($conceptoNombre) {
                        $q->where('nombre', 'ilike', $conceptoNombre)
                          ->orWhere('concepto_er_nombre', 'ilike', $conceptoNombre);
                    })
                    ->first();
                
                if (!$concepto) continue;

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
                            'monto' => Crypt::encryptString((string)$monto),
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
                foreach (array_chunk($upsertData, 500) as $chunk) {
                    RegistroFinanciero::upsert(
                        $chunk,
                        ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                        ['monto', 'updated_at']
                    );
                }
            }

            DB::commit();
            return $registrosGuardados;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
