<?php

namespace App\Application\UseCases\ER;

use App\Domain\Services\ERDomainService;
use App\Domain\Services\POADomainService;
use App\Models\ResultadoMensual;
use App\Imports\ERImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportarER
{
    private ERDomainService $erDomainService;
    private POADomainService $poaDomainService;

    public function __construct(
        ERDomainService $erDomainService,
        POADomainService $poaDomainService
    ) {
        $this->erDomainService = $erDomainService;
        $this->poaDomainService = $poaDomainService;
    }

    public function execute(int $anio, $archivo): array
    {
        Excel::import(new ERImport($anio), $archivo);

        $almacenesAfectados = ResultadoMensual::where('anio', $anio)
            ->distinct()
            ->pluck('almacen_id');

        $totalSincronizados = 0;
        foreach ($almacenesAfectados as $almacenId) {
            $totalSincronizados += $this->poaDomainService->sincronizarDesdeER($almacenId, $anio);
        }

        return [
            'message' => "Archivo importado y {$totalSincronizados} metas POA sincronizadas.",
            'count' => $totalSincronizados,
            'almacenesCount' => $almacenesAfectados->count(),
        ];
    }
}