<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Porcentajes de Merma y Quebranto por Línea de Producto
    |--------------------------------------------------------------------------
    |
    | Estos porcentajes se aplican sobre las ventas ($) de cada línea para
    | calcular el importe comprometido de MERMAS, QUEBRANTOS Y MAL ESTADO.
    | Los valores están expresados como porcentaje (ej. 0.150 = 0.150%).
    | El código divide internamente entre 100 al calcular.
    |
    */
    'lineas' => [
        'MAIZ' => [
            'merma' => 0.150,
            'quebranto' => 0.100,
        ],
        'FRIJOL' => [
            'merma' => 0.050,
            'quebranto' => 0.010,
        ],
        'ARROZ' => [
            'merma' => 0.040,
            'quebranto' => 0.010,
        ],
        'AZUCAR' => [
            'merma' => 0.040,
            'quebranto' => 0.010,
        ],
        'H.DE MAIZ' => [
            'merma' => 0.000,
            'quebranto' => 0.050,
        ],
        'LECHE SUB' => [
            'merma' => 0.000,
            'quebranto' => 0.050,
        ],
        'ABARROTES' => [
            'merma' => 0.000,
            'quebranto' => 0.050,
        ],
        'MERC GRALES' => [
            'merma' => 0.000,
            'quebranto' => 0.050,
        ],
    ],
];
