<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosER;
use App\Models\ConceptoER;
use App\Models\ResultadoMensual;

class ERDomainService
{
    public function obtenerDatosER(FiltrosER $filtros): array
    {
        $query = ResultadoMensual::where('anio', $filtros->getAnio());

        if ($filtros->getAlmacenId()) {
            $query->where('almacen_id', $filtros->getAlmacenId());
        }

        $resultadosRaw = $query->get();

        return $this->buildMatriz($resultadosRaw);
    }

    public function obtenerConceptos(): \Illuminate\Database\Eloquent\Collection
    {
        return ConceptoER::orderBy('orden_visual', 'asc')->get();
    }

    private function buildMatriz($resultadosRaw): array
    {
        $matriz = [];
        foreach ($resultadosRaw as $res) {
            if (!isset($matriz[$res->concepto_er_id])) {
                $matriz[$res->concepto_er_id] = array_fill(1, 12, 0);
            }
            $matriz[$res->concepto_er_id][$res->mes] += $res->monto;
        }
        return $matriz;
    }

    public function guardarRegistro(
        int $almacenId,
        int $conceptoErId,
        int $anio,
        int $mes,
        float $monto
    ): void {
        ResultadoMensual::updateOrCreate(
            [
                'almacen_id' => $almacenId,
                'concepto_er_id' => $conceptoErId,
                'anio' => $anio,
                'mes' => $mes,
            ],
            [
                'monto' => $monto
            ]
        );
    }
}