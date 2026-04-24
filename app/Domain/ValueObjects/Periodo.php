<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Periodo
{
    public const MENSUAL = 'mensual';
    public const TRIMESTRAL = 'trimestral';
    public const ANUAL = 'anual';

    private const MESES_POR_TRIMESTRE = [
        1 => [1, 2, 3],
        2 => [4, 5, 6],
        3 => [7, 8, 9],
        4 => [10, 11, 12],
    ];

    private const NOMBRES_MESES = [
        1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
        5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
        9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE',
    ];

    private const NOMBRES_TRIMESTRES = [
        1 => 'ENE-MAR', 2 => 'ABR-JUN', 3 => 'JUL-SEP', 4 => 'OCT-DIC',
    ];

    private string $tipo;
    private int $mes;
    private int $trimestre;

    public function __construct(string $tipo = self::MENSUAL, int $mes = 1, int $trimestre = 1)
    {
        $this->tipo = $tipo;
        $this->mes = $mes;
        $this->trimestre = $trimestre;

        if (!in_array($tipo, [self::MENSUAL, self::TRIMESTRAL, self::ANUAL])) {
            throw new InvalidArgumentException("Tipo de período inválido: {$tipo}");
        }
    }

    public static function createFromRequest(array $request): self
    {
        $tipo = $request['periodo'] ?? self::MENSUAL;
        $mes = (int) ($request['mes'] ?? date('m'));
        $trimestre = (int) ($request['trimestre'] ?? ceil($mes / 3));

        return new self($tipo, $mes, $trimestre);
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getMeses(): array
    {
        return match ($this->tipo) {
            self::MENSUAL => [$this->mes],
            self::TRIMESTRAL => self::MESES_POR_TRIMESTRE[$this->trimestre] ?? [1, 2, 3],
            self::ANUAL => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        };
    }

    public function getLabel(): string
    {
        return match ($this->tipo) {
            self::MENSUAL => self::NOMBRES_MESES[$this->mes] ?? 'ENERO',
            self::TRIMESTRAL => 'T' . $this->trimestre . ' ' . (self::NOMBRES_TRIMESTRES[$this->trimestre] ?? ''),
            self::ANUAL => 'ANUAL',
        };
    }
}