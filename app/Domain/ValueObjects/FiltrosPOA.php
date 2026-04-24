<?php

namespace App\Domain\ValueObjects;

class FiltrosPOA
{
    private int $anio;
    private ?int $almacenId;
    private bool $consolidado;
    private Periodo $periodo;

    public function __construct(
        int $anio,
        ?int $almacenId,
        bool $consolidado,
        Periodo $periodo
    ) {
        $this->anio = $anio;
        $this->almacenId = $almacenId;
        $this->consolidado = $consolidado;
        $this->periodo = $periodo;
    }

    public static function createFromRequest(array $request): self
    {
        $anio = (int) ($request['anio'] ?? date('Y'));
        $almacenId = !empty($request['almacen_id']) ? (int) $request['almacen_id'] : null;
        $consolidado = ($request['consolidado'] ?? 'si') === 'si';
        $periodo = Periodo::createFromRequest($request);

        return new self($anio, $almacenId, $consolidado, $periodo);
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function getAlmacenId(): ?int
    {
        return $this->almacenId;
    }

    public function isConsolidado(): bool
    {
        return $this->consolidado;
    }

    public function getPeriodo(): Periodo
    {
        return $this->periodo;
    }

    public function toArray(): array
    {
        return [
            'anio' => $this->anio,
            'almacen_id' => $this->almacenId,
            'consolidado' => $this->consolidado ? 'si' : 'no',
            'periodo' => $this->periodo->getTipo(),
            'mes' => $this->periodo->getMeses()[0] ?? 1,
            'trimestre' => 1,
        ];
    }
}