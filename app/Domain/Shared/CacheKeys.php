<?php

namespace App\Domain\Shared;

class CacheKeys
{
    public const ALMACENES = 'almacenes_ordenados';
    public const CONCEPTOS_POA = 'conceptos_poa';
    public const CONCEPTOS_ER = 'conceptos_er';
    public const CONCEPTOS_ER_PLUCK = 'conceptos_er_pluck';
    public const CONCEPTOS_LP_IDS = 'conceptos_lp_ids';
    public const POA_VERSION = 'poa_cache_version';

    /**
     * Helper to get dashboard cache key
     */
    public static function dashboardData(int $anio, string $version): string
    {
        return "dashboard_data_{$anio}_v{$version}";
    }

    /**
     * Helper to get ER data cache key
     */
    public static function erData(int $anio, ?int $almacenId, string $version): string
    {
        $storeStr = $almacenId ?? 'all';
        return "er_data_{$anio}_{$storeStr}_v{$version}";
    }

    /**
     * Helper to get POA data cache key
     */
    public static function poaData(int $anio, ?int $almacenId, string $periodoTipo, string $notaMes, string $version): string
    {
        $storeStr = $almacenId ?? 'all';
        return "poa_data_{$anio}_{$storeStr}_{$periodoTipo}_{$notaMes}_v{$version}";
    }
}
