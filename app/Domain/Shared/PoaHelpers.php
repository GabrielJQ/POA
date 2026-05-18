<?php

namespace App\Domain\Shared;

class PoaHelpers
{
    /**
     * Retorna el nombre de la columna para un mes (ej: 1 -> 'mes_01')
     */
    public static function columnaMes(int $mes): string
    {
        return 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Determina si la unidad de medida de un concepto es de tipo porcentaje
     */
    public static function esPorcentaje(?string $unidadMedida): bool
    {
        return stripos($unidadMedida ?? '', 'PORCENTAJE') !== false;
    }

    /**
     * Determina si el concepto es Presupuesto de Ventas
     */
    public static function esVentas(?string $nombreConcepto): bool
    {
        return stripos($nombreConcepto ?? '', 'PRESUPUESTO DE VENTA') !== false;
    }

    /**
     * Determina el programa (PAR o PE) en base al nombre del concepto
     */
    public static function detectarPrograma(?string $nombreConcepto): ?string
    {
        if (stripos($nombreConcepto ?? '', 'PAR') !== false) {
            return 'PAR';
        } 
        if (stripos($nombreConcepto ?? '', 'PE') !== false) {
            return 'PE';
        }
        return null;
    }
}
