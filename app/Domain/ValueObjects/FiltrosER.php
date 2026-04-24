<?php

namespace App\Domain\ValueObjects;

class FiltrosER
{
    private int $anio;
    private ?int $almacenId;

    public function __construct(
        int $anio,
        ?int $almacenId
    ) {
        $this->anio = $anio;
        $this->almacenId = $almacenId;
    }

    public static function createFromRequest(array $request): self
    {
        $anio = (int) ($request['anio'] ?? date('Y'));
        $almacenId = !empty($request['almacen_id']) ? (int) $request['almacen_id'] : null;

        return new self($anio, $almacenId);
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
        return $this->almacenId === null;
    }

    public function toArray(): array
    {
        return [
            'anio' => $this->anio,
            'almacen_id' => $this->almacenId,
        ];
    }
}