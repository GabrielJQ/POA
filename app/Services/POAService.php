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
     * Solo sincroniza los datos COMPROMETIDOS desde el ER.
     * Los datos REALIZADOS son de otro módulo y no se tocan aquí.
     */
    public function syncFromER(int $almacenId, int $anio): int
    {
        $compromisosSincronizados = 0;
        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();

        foreach ($compromisos as $compromiso) {
            $conceptoNombre = trim($compromiso->concepto_er_nombre);
            
            if (empty($conceptoNombre)) {
                continue;
            }

            // Buscar concepto exacto
            $concepto = ConceptoER::where('nombre', 'ilike', $conceptoNombre)->first();

            // Si no existe exacto, buscar parcial
            if (!$concepto) {
                $concepto = ConceptoER::where('nombre', 'ilike', '%' . $conceptoNombre . '%')->first();
            }

            // Si aún no existe, crear registro vacío solo para COMPROMETIDO
            if (!$concepto) {
                PoaRegistro::updateOrCreate([
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_1,
                ], ['meta_anual' => 0]);
                continue;
            }

            // Obtener montos mensuales desde resultados_mensuales
            $montosmensuales = [];
            $metaAnual = 0;

            for ($mes = 1; $mes <= 12; $mes++) {
                $monto = (float) ResultadoMensual::where('almacen_id', $almacenId)
                    ->where('anio', $anio)
                    ->where('mes', $mes)
                    ->where('concepto_er_id', $concepto->id)
                    ->value('monto') ?? 0;

                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $montosmensuales[$col] = $monto;
                $metaAnual += $monto;
            }

            // Guardar solo COMPROMETIDO
            PoaRegistro::updateOrCreate(
                [
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_1,
                ],
                array_merge($montosmensuales, ['meta_anual' => $metaAnual])
            );

            $compromisosSincronizados++;
        }

        return $compromisosSincronizados;
    }
}