<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Models\CompromisoPoa;
use App\Models\PoaRegistro;
use App\Models\ResultadoMensual;
use App\Models\ConceptoER;

class POADomainService
{
    /**
     * Obtiene los datos del POA según los filtros dados
     * Lógica de negocio pura - sin dependencias de framework
     */
    public function obtenerDatosPOA(FiltrosPOA $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();
        $meses = $filtros->getPeriodo()->getMeses();

        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();

        if ($filtros->isConsolidado()) {
            return $this->buildConsolidado($compromisos, $anio, $meses);
        }

        return $this->buildIndividual($compromisos, $anio, $almacenId, $meses);
    }

    /**
     * Sincroniza los compromisos desde el Estado de Resultados
     * returns: número de compromisos sincronizados
     */
    public function sincronizarDesdeER(int $almacenId, int $anio): int
    {
        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();

        $sincronizados = 0;

        foreach ($compromisos as $compromiso) {
            $conceptoNombre = trim($compromiso->concepto_er_nombre);
            if (empty($conceptoNombre)) {
                continue;
            }

            $concepto = ConceptoER::where('nombre', 'ilike', $conceptoNombre)->first();
            if (!$concepto) {
                $concepto = ConceptoER::where('nombre', 'ilike', '%' . $conceptoNombre . '%')->first();
            }

            if (!$concepto) {
                PoaRegistro::updateOrCreate([
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_1,
                ], ['meta_anual' => 0]);
                continue;
            }

            $montos = [];
            $metaAnual = 0;

            for ($mes = 1; $mes <= 12; $mes++) {
                $monto = (float) ResultadoMensual::where('almacen_id', $almacenId)
                    ->where('anio', $anio)
                    ->where('mes', $mes)
                    ->where('concepto_er_id', $concepto->id)
                    ->value('monto') ?? 0;

                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $montos[$col] = $monto;
                $metaAnual += $monto;
            }

            PoaRegistro::updateOrCreate(
                [
                    'compromiso_poa_id' => $compromiso->id,
                    'almacen_id' => $almacenId,
                    'anio' => $anio,
                    'tipo_registro' => $compromiso->label_fila_1,
                ],
                array_merge($montos, ['meta_anual' => $metaAnual])
            );

            $sincronizados++;
        }

        return $sincronizados;
    }

    private function buildConsolidado($compromisos, int $anio, array $meses): array
    {
        $compromisosIds = $compromisos->pluck('id')->toArray();

        $registros = PoaRegistro::where('anio', $anio)
            ->whereIn('compromiso_poa_id', $compromisosIds)
            ->get();

        $dataPoa = [];

        foreach ($compromisos as $compromiso) {
            $filas1 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_1);
            $filas2 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_2);

            $metaAnual1 = $filas1->sum('meta_anual');
            $metaAnual2 = $filas2->sum('meta_anual');

            $obj1 = new \stdClass();
            $obj1->meta_anual = $metaAnual1;
            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $suma = 0;
                foreach ($filas1 as $fila) {
                    $suma += (float) ($fila->$col ?? 0);
                }
                $obj1->$col = $suma;
            }

            $obj2 = new \stdClass();
            $obj2->meta_anual = $metaAnual2;
            foreach ($meses as $mes) {
                $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
                $suma = 0;
                foreach ($filas2 as $fila) {
                    $suma += (float) ($fila->$col ?? 0);
                }
                $obj2->$col = $suma;
            }

            $dataPoa[$compromiso->id][$compromiso->label_fila_1] = $obj1;
            $dataPoa[$compromiso->id][$compromiso->label_fila_2] = $obj2;
        }

        return $dataPoa;
    }

    private function buildIndividual($compromisos, int $anio, ?int $almacenId, array $meses): array
    {
        $query = PoaRegistro::where('anio', $anio);

        if ($almacenId) {
            $query->where('almacen_id', $almacenId);
        }

        $compromisosIds = $compromisos->pluck('id')->toArray();
        $query->whereIn('compromiso_poa_id', $compromisosIds);

        $registros = $query->get();

        $dataPoa = [];

        foreach ($compromisos as $compromiso) {
            $fila1 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_1)
                ->first();
            $fila2 = $registros->where('compromiso_poa_id', $compromiso->id)
                ->where('tipo_registro', $compromiso->label_fila_2)
                ->first();

            if ($fila1) {
                $dataPoa[$compromiso->id][$compromiso->label_fila_1] = $fila1;
            }
            if ($fila2) {
                $dataPoa[$compromiso->id][$compromiso->label_fila_2] = $fila2;
            }
        }

        return $dataPoa;
    }
}