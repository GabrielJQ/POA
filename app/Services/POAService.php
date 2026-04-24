<?php

namespace App\Services;

use App\Models\CompromisoPoa;
use App\Models\PoaRegistro;
use App\Models\ResultadoMensual;
use App\Models\ConceptoER;

class POAService
{
    /**
     * Sincroniza las metas comprometidas del POA desde el Estado de Resultados.
     * 
     * Para cada compromiso que tenga un concepto_er_nombre mapeado:
     * 1. Busca el concepto en la tabla conceptos_er
     * 2. Obtiene los 12 montos mensuales de resultados_mensuales
     * 3. Crea/actualiza el registro COMPROMETIDO en poa_registros
     *
     * @param int $almacenId
     * @param int $anio
     * @return int Número de compromisos sincronizados
     */
    public function syncFromER(int $almacenId, int $anio): int
    {
        $compromisosSincronizados = 0;

        // Solo procesamos compromisos que tienen mapping con el ER
        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')->get();

        foreach ($compromisos as $compromiso) {
            // Buscar el concepto en el ER (insensible a mayúsculas para PostgreSQL)
            $concepto = ConceptoER::where('nombre', 'ilike', $compromiso->concepto_er_nombre)->first();

            if (!$concepto) {
                continue; // Si no existe el concepto en el ER, saltamos
            }

            // Obtener los 12 montos mensuales
            $montosmensuales = [];
            $metaAnual = 0;

            for ($mes = 1; $mes <= 12; $mes++) {
                $monto = ResultadoMensual::where('almacen_id', $almacenId)
                    ->where('anio', $anio)
                    ->where('concepto_er_id', $concepto->id)
                    ->where('mes', $mes)
                    ->value('monto') ?? 0;

                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $montosmensuales[$col] = (float) $monto;
                $metaAnual += (float) $monto;
            }

            // Crear/Actualizar el registro COMPROMETIDO
            PoaRegistro::updateOrCreate(
                [
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_1, // 'COMPROMETIDO'
                ],
                array_merge($montosmensuales, ['meta_anual' => $metaAnual])
            );

            // Asegurar que también exista la fila REALIZADO (vacía si no tiene datos)
            PoaRegistro::firstOrCreate(
                [
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_2, // 'REALIZADO'
                ]
            );

            $compromisosSincronizados++;
        }

        // También crear filas vacías para compromisos sin mapping al ER
        $compromisosSinMapping = CompromisoPoa::whereNull('concepto_er_nombre')->get();
        foreach ($compromisosSinMapping as $compromiso) {
            PoaRegistro::firstOrCreate([
                'compromiso_poa_id' => $compromiso->id,
                'almacen_id' => $almacenId,
                'anio' => $anio,
                'tipo_registro' => $compromiso->label_fila_1,
            ]);
            PoaRegistro::firstOrCreate([
                'compromiso_poa_id' => $compromiso->id,
                'almacen_id' => $almacenId,
                'anio' => $anio,
                'tipo_registro' => $compromiso->label_fila_2,
            ]);
        }

        return $compromisosSincronizados;
    }
}
