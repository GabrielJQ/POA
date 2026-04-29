<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Models\UnidadOperativa;
use App\Models\Regional;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exception;

class ERImport implements ToCollection, WithCalculatedFormulas
{
    protected $anio;

    public function __construct($anio)
    {
        $this->anio = $anio;
    }

    public function collection(Collection $rows)
    {
        $unidadOperativaNombre = trim($rows[3][3] ?? '');
        $almacenNombre = trim($rows[4][3] ?? '');

        if (empty($unidadOperativaNombre)) $unidadOperativaNombre = 'Unidad Desconocida';
        if (empty($almacenNombre)) $almacenNombre = 'Almacén Desconocido';

        DB::beginTransaction();
        try {
            $regional = Regional::firstOrCreate(
                ['nombre' => 'General'],
                ['nombre' => 'General']
            );

            $unidadOperativa = UnidadOperativa::where('nombre', 'ilike', $unidadOperativaNombre)->first();
            if (!$unidadOperativa) {
                $region = Regional::first();
                $unidadOperativa = UnidadOperativa::create([
                    'nombre' => $unidadOperativaNombre,
                    'regional_id' => $region ? $region->id : 1,
                ]);
            }

            $almacen = Almacen::where('nombre', 'ilike', $almacenNombre)->first();
            if (!$almacen) {
                $almacen = Almacen::create([
                    'nombre' => $almacenNombre,
                    'unidad_operativa_id' => $unidadOperativa->id,
                ]);
            }

            $registrosGuardados = 0;
            $upsertData = [];
            $now = now();

            for ($i = 12; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                $conceptoNombre = trim($row[0] ?? '');
                if (empty($conceptoNombre)) {
                    $conceptoNombre = trim($row[1] ?? '');
                }
                if (empty($conceptoNombre)) {
                    $conceptoNombre = trim($row[2] ?? '');
                }
                
                if (empty($conceptoNombre)) {
                    continue; 
                }

                $conceptoMayus = mb_strtoupper($conceptoNombre, 'UTF-8');
                if (str_contains($conceptoMayus, 'ELABORÓ') || str_contains($conceptoMayus, 'ELABORO')) {
                    break;
                }

                // Buscar concepto existente por nombre exacto (usar solo los del seeder)
                $concepto = ConceptoMaestro::where('categoria', 'ER')
                    ->where(function($q) use ($conceptoNombre) {
                        $q->where('nombre', $conceptoNombre)
                          ->orWhere('nombre', 'ilike', $conceptoNombre)
                          ->orWhere('concepto_er_nombre', $conceptoNombre);
                    })
                    ->first();
                
                // Si no se encuentra, saltar esta fila
                if (!$concepto) {
                    continue;
                }

                // ENERO está en columna D (índice 3) según el formato ER
                // Si no funciona, cambiar el 3 por el índice correcto
                $columnaInicio = 3; // Columna D = índice 3
                
                for ($mes = 1; $mes <= 12; $mes++) {
                    $indiceColumna = $columnaInicio + ($mes - 1);
                    $montoRaw = $row[$indiceColumna] ?? null;
                    
                    // Si el valor es null o vacío, saltar
                    if ($montoRaw === null || $montoRaw === '') {
                        continue;
                    }
                    
                    // Limpiar el monto de caracteres no numéricos (excepto - y .)
                    $montoLimpio = preg_replace('/[^\d.-]/', '', (string)$montoRaw);
                    
                    // Si después de limpiar está vacío o no es numérico, saltar
                    if ($montoLimpio === '' || !is_numeric($montoLimpio)) {
                        continue;
                    }
                    
                    $monto = (float)$montoLimpio;
                    
                    // Solo guardar si el monto es diferente de 0
                    if ($monto != 0) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $concepto->id,
                            'anio' => $this->anio,
                            'mes' => $mes,
                            'monto' => $monto,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $registrosGuardados++;
                    }
                }
            }

            if ($registrosGuardados === 0) {
                throw new Exception("No se encontró ningún monto válido. Verifica que el archivo cumpla la estructura.");
            }

            foreach (array_chunk($upsertData, 500) as $chunk) {
                foreach ($chunk as &$data) {
                    $data['monto'] = Crypt::encryptString((string)$data['monto']);
                }
                RegistroFinanciero::upsert(
                    $chunk,
                    ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                    ['monto', 'updated_at']
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
