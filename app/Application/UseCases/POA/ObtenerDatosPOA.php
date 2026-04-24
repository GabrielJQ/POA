<?php

namespace App\Application\UseCases\POA;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\Services\POADomainService;
use App\Models\CompromisoPoa;
use App\Models\Almacen;

class ObtenerDatosPOA
{
    private POADomainService $domainService;

    public function __construct(POADomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * Caso de uso: Obtener datos del POA para visualización
     */
    public function execute(array $request): array
    {
        $filtros = FiltrosPOA::createFromRequest($request);

        $dataPoa = $this->domainService->obtenerDatosPOA($filtros);
        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();
        $almacenes = Almacen::orderBy('nombre')->get();

        return [
            'compromisos' => $compromisos,
            'dataPoa' => $dataPoa,
            'almacenes' => $almacenes,
            'filtros' => $filtros,
            'anioSeleccionado' => $filtros->getAnio(),
            'almacenSeleccionado' => $filtros->getAlmacenId(),
            'mesActual' => $filtros->getPeriodo()->getMeses()[0] ?? 1,
            'trimestreSeleccionado' => 1,
            'periodoTipo' => $filtros->getPeriodo()->getTipo(),
            'mostrarConsolidado' => $filtros->isConsolidado(),
            'labelPeriodo' => $filtros->getPeriodo()->getLabel(),
            'meses' => $this->getNombresMeses(),
            'trimestres' => $this->getNombresTrimestres(),
            'config' => [
                'meses' => $filtros->getPeriodo()->getMeses(),
                'nombre' => $filtros->getPeriodo()->getTipo(),
            ],
        ];
    }

    public function executeParaVista(array $request): array
    {
        $filtros = FiltrosPOA::createFromRequest($request);

        $dataPoa = $this->domainService->obtenerDatosPOA($filtros);
        $compromisos = CompromisoPoa::whereNotNull('concepto_er_nombre')
            ->where('concepto_er_nombre', '!=', '')
            ->orderBy('orden')
            ->get();

        return [
            'compromisos' => $compromisos,
            'dataPoa' => $dataPoa,
            'periodoTipo' => $filtros->getPeriodo()->getTipo(),
            'labelPeriodo' => $filtros->getPeriodo()->getLabel(),
            'config' => [
                'meses' => $filtros->getPeriodo()->getMeses(),
                'nombre' => $filtros->getPeriodo()->getTipo(),
            ],
            'meses' => $this->getNombresMeses(),
            'trimestres' => $this->getNombresTrimestres(),
        ];
    }

    private function getNombresMeses(): array
    {
        return [
            1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
            5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
            9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE',
        ];
    }

    private function getNombresTrimestres(): array
    {
        return [
            1 => 'ENE-MAR', 2 => 'ABR-JUN', 3 => 'JUL-SEP', 4 => 'OCT-DIC',
        ];
    }
}