<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoER;
use App\Models\ResultadoMensual;
use App\Models\UnidadOperativa;
use App\Models\Regional;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
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
        // En Excel: Fila 4 = índice 3, Fila 5 = índice 4.
        // Según la imagen: El título está en B (1) pero el valor en D (3).
        $unidadOperativaNombre = trim($rows[3][3] ?? '');
        $almacenNombre = trim($rows[4][3] ?? '');

        // Valores por defecto por si el usuario borró la celda
        if (empty($unidadOperativaNombre)) $unidadOperativaNombre = 'Unidad Desconocida';
        if (empty($almacenNombre)) $almacenNombre = 'Almacén Desconocido';

        DB::beginTransaction();
        try {
            // 1. Obtener o crear Regional genérica
            $regional = Regional::firstOrCreate(
                ['nombre' => 'General'],
                ['clave_region' => 'GEN']
            );

            // 2. Obtener o crear Unidad Operativa (Búsqueda insensible a mayúsculas para Postgres)
            $unidadOperativa = UnidadOperativa::where('nombre', 'ilike', $unidadOperativaNombre)->first();
            if (!$unidadOperativa) {
                // Si no existe, la creamos asumiendo la primera región
                $region = Regional::first();
                $unidadOperativa = UnidadOperativa::create([
                    'nombre' => $unidadOperativaNombre,
                    'regional_id' => $region ? $region->id : 1,
                    'clave_unidad' => strtoupper(substr($unidadOperativaNombre, 0, 5))
                ]);
            }

            // 3. Obtener o crear Almacén (Búsqueda insensible a mayúsculas)
            $almacen = Almacen::where('nombre', 'ilike', $almacenNombre)->first();
            if (!$almacen) {
                $almacen = Almacen::create([
                    'nombre' => $almacenNombre,
                    'unidad_operativa_id' => $unidadOperativa->id,
                    'clave_almacen' => strtoupper(substr($almacenNombre, 0, 5))
                ]);
            }

            $registrosGuardados = 0;
            $upsertData = []; // Array masivo
            $now = now();

            // 4. Iterar datos numéricos (Fila 13 = índice 12)
            for ($i = 12; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // En Excel, los subtotales a veces están movidos a la Columna B (1) o C (2) por diseño visual
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

                // Si llegamos a la zona de firmas al final del documento, detenemos la lectura
                $conceptoMayus = mb_strtoupper($conceptoNombre, 'UTF-8');
                if (str_contains($conceptoMayus, 'ELABORÓ') || str_contains($conceptoMayus, 'ELABORO')) {
                    break;
                }

                $concepto = ConceptoER::firstOrCreate(
                    ['nombre' => $conceptoNombre],
                    [
                        'categoria' => 'Importado',
                        'tipo' => 1,
                        'orden_visual' => 0,
                        'es_calculado' => false
                    ]
                );

                // Los meses de Enero a Diciembre están de la Columna D (3) a la O (14)
                for ($mes = 1; $mes <= 12; $mes++) {
                    $indiceColumna = $mes + 2; // 1 (Enero) + 2 = 3 (Columna D)
                    $montoRaw = $row[$indiceColumna] ?? null;
                    
                    // Limpiar el monto (quitar $, comas, espacios, paréntesis)
                    // Tratamos valores como (150) contablemente como negativos si hiciera falta, pero limpiaremos todo lo no numérico.
                    $montoLimpio = preg_replace('/[^\d.-]/', '', (string)$montoRaw);

                    if ($montoLimpio !== '' && is_numeric($montoLimpio)) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_er_id' => $concepto->id,
                            'anio' => $this->anio,
                            'mes' => $mes,
                            'monto' => (float)$montoLimpio,
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

            // 5. Inserción Masiva (Súper rápida, evita el Timeout)
            foreach (array_chunk($upsertData, 500) as $chunk) {
                ResultadoMensual::upsert(
                    $chunk,
                    ['almacen_id', 'concepto_er_id', 'anio', 'mes'], // Llaves únicas
                    ['monto', 'updated_at'] // Qué actualizar si ya existe
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
