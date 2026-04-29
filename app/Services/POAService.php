<?php

namespace App\Services;

use App\Models\ConceptoMaestro;
use App\Models\Poa;
use App\Models\RegistroFinanciero;

class POAService
{
    public function syncFromER(int $almacenId, int $anio): int
    {
        $compromisosSincronizados = 0;
        $compromisos = ConceptoMaestro::where('categoria', 'POA')
            ->whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();

        foreach ($compromisos as $compromiso) {
            $conceptoNombre = trim($compromiso->concepto_er_nombre);

            if (empty($conceptoNombre)) {
                continue;
            }

            // Buscar concepto ER correspondiente
            $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                ->where('nombre', 'ilike', $conceptoNombre)
                ->first();

            if (!$conceptoER) {
                $conceptoER = ConceptoMaestro::where('categoria', 'ER')
                    ->where('nombre', 'ilike', '%' . $conceptoNombre . '%')
                    ->first();
            }

            // Si no existe, crear registro vacío solo para COMPROMETIDO
            if (!$conceptoER) {
                RegistroFinanciero::updateOrCreate([
                    'almacen_id' => $almacenId,
                    'concepto_id' => $compromiso->id,
                    'anio' => $anio,
                    'mes' => 0,
                    'tipo_dato' => 'META',
                ], ['monto' => 0]);
                continue;
            }

            // Obtener montos mensuales desde registros_financieros (tipo_dato = REAL)
            $montosMensuales = [];
            $metaAnual = 0;

            for ($mes = 1; $mes <= 12; $mes++) {
                $monto = (float) RegistroFinanciero::where('almacen_id', $almacenId)
                    ->where('anio', $anio)
                    ->where('mes', $mes)
                    ->where('tipo_dato', 'REAL')
                    ->where('concepto_id', $conceptoER->id)
                    ->value('monto') ?? 0;

                $montosMensuales[$mes] = $monto;
                $metaAnual += $monto;
            }

            // Guardar como COMPROMETIDO (META)
            RegistroFinanciero::updateOrCreate(
                [
                    'almacen_id' => $almacenId,
                    'concepto_id' => $compromiso->id,
                    'anio' => $anio,
                    'tipo_dato' => 'META',
                    'mes' => 0,
                ],
                ['monto' => $metaAnual]
            );

            $compromisosSincronizados++;
        }

        return $compromisosSincronizados;
    }

    public function syncVentasParPeToPOA(int $almacenId, string $programa, int $mes, int $anio): float
    {
        $total = RegistroFinanciero::where('almacen_id', $almacenId)
            ->where('programa', $programa)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->where('tipo_dato', 'REAL')
            ->sum('monto');

        if ($total <= 0) {
            return 0;
        }

        $poa = Poa::where('almacen_id', $almacenId)
            ->where('anio', $anio)
            ->first();

        if (!$poa) {
            $poa = Poa::create([
                'almacen_id' => $almacenId,
                'anio' => $anio,
                'tipo_registro' => 'VENTAS',
            ]);
        }

        if ($programa === 'PAR') {
            $poa->update(['presupuesto_venta_par' => $total]);
        } elseif ($programa === 'PE') {
            $poa->update(['presupuesto_venta_pe' => $total]);
        }

        return $total;
    }
}
