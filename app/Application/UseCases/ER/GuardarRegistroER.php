<?php

namespace App\Application\UseCases\ER;

use App\Domain\Services\ERDomainService;

class GuardarRegistroER
{
    private ERDomainService $domainService;

    public function __construct(ERDomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function execute(array $data): void
    {
        $this->domainService->guardarRegistro(
            (int) $data['almacen_id'],
            (int) $data['concepto_er_id'],
            (int) $data['anio'],
            (int) $data['mes'],
            (float) $data['monto']
        );
    }
}