<?php

namespace App\Application\UseCases\ER;

use App\Domain\Contracts\IERDomainService;

class GuardarRegistroER
{
    private IERDomainService $domainService;

    public function __construct(IERDomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function execute(array $data): void
    {
        $this->domainService->guardarManual([
            'almacen_id' => (int) $data['almacen_id'],
            'concepto_id' => (int) $data['concepto_id'],
            'anio' => (int) $data['anio'],
            'mes' => (int) $data['mes'],
            'monto' => (float) $data['monto'],
        ]);
    }
}
