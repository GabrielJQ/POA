<?php

namespace App\Application\UseCases\ER;

use App\Domain\Contracts\IERDomainService;
use App\Domain\Contracts\IPOADomainService;
use App\Models\RegistroFinanciero;
use App\Imports\ERImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportarER
{
    private IERDomainService $erDomainService;
    private IPOADomainService $poaDomainService;

    public function __construct(
        IERDomainService $erDomainService,
        IPOADomainService $poaDomainService
    ) {
        $this->erDomainService = $erDomainService;
        $this->poaDomainService = $poaDomainService;
    }

    public function execute(int $anio, $archivo): array
    {
        Excel::import(new ERImport($anio), $archivo);

        $almacenesAfectados = RegistroFinanciero::where('anio', $anio)
            ->where('tipo_dato', 'REAL')
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
