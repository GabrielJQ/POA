<?php

namespace App\Domain\Services\Dashboard\Builders;

class DashboardDataAssembler
{
    public function assemble(
        array $indicePorAlmacen, 
        int $totalAlmacenes
    ): array {
        usort($indicePorAlmacen, fn($a, $b) => ($a['indice'] ?? 999) <=> ($b['indice'] ?? 999));

        $enRojo = 0;
        $enAtencion = 0;
        $totalSinDatos = 0;

        foreach ($indicePorAlmacen as $s) {
            if ($s['indice'] !== null) {
                if ($s['indice'] < 30) {
                    $enRojo++;
                } elseif ($s['indice'] < 50) {
                    $enAtencion++;
                }
            } else {
                $totalSinDatos++;
            }
        }

        $conDatos = array_filter($indicePorAlmacen, fn($s) => $s['indice'] !== null);
        $conDatos = array_values($conDatos);

        $top3 = array_slice(array_reverse($conDatos), 0, 3);
        $bottom3 = array_slice($conDatos, 0, 3);

        $suma = 0;
        $count = 0;
        foreach ($indicePorAlmacen as $s) {
            if ($s['indice'] !== null) {
                $suma += $s['indice'];
                $count++;
            }
        }
        $indiceConsolidado = $count > 0 ? $suma / $count : 0;
        $totalConDatos = $totalAlmacenes - $totalSinDatos;

        return compact(
            'totalAlmacenes', 'totalConDatos', 'totalSinDatos',
            'indiceConsolidado', 'enRojo', 'enAtencion',
            'indicePorAlmacen', 'top3', 'bottom3',
        );
    }
}
