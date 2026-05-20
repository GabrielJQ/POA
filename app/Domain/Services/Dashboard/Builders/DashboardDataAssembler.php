<?php

namespace App\Domain\Services\Dashboard\Builders;

class DashboardDataAssembler
{
    public function assemble(
        array $indicePorAlmacen, 
        int $totalAlmacenes
    ): array {
        usort($indicePorAlmacen, fn($a, $b) => ($a['indice'] ?? 999) <=> ($b['indice'] ?? 999));

        $verde = [];    // >= 75%
        $amarillo = []; // >= 50% y < 75%
        $naranja = [];  // >= 30% y < 50%
        $rojo = [];     // < 30%
        $totalSinDatos = 0;

        foreach ($indicePorAlmacen as $s) {
            if ($s['indice'] === null) {
                $totalSinDatos++;
            } elseif ($s['indice'] >= 75) {
                $verde[] = $s;
            } elseif ($s['indice'] >= 50) {
                $amarillo[] = $s;
            } elseif ($s['indice'] >= 30) {
                $naranja[] = $s;
            } else {
                $rojo[] = $s;
            }
        }

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
            'indiceConsolidado',
            'indicePorAlmacen',
            'verde', 'amarillo', 'naranja', 'rojo',
        );
    }
}
