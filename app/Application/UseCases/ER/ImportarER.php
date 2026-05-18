<?php

namespace App\Application\UseCases\ER;

use App\Domain\Contracts\IERDomainService;
use App\Domain\Contracts\IPOADomainService;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Imports\ERImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportarER
{
    private IERDomainService $erDomainService;
    private IPOADomainService $poaDomainService;
    private IRegistroFinancieroRepository $registroRepo;

    public function __construct(
        IERDomainService $erDomainService,
        IPOADomainService $poaDomainService,
        IRegistroFinancieroRepository $registroRepo
    ) {
        $this->erDomainService = $erDomainService;
        $this->poaDomainService = $poaDomainService;
        $this->registroRepo = $registroRepo;
    }

    public function execute(int $anio, $archivo): array
    {
        Excel::import(new ERImport($anio), $archivo);

        $almacenesAfectados = $this->registroRepo->getDistinctAlmacenesByAnioYTipo($anio, 'REAL')
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
