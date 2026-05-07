<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConceptoMaestro;

class ConceptoERSeeder extends Seeder
{
    public function run(): void
    {
        $conceptos = [
            ['nombre' => 'VENTAS A TIENDAS', 'orden' => 1, 'concepto_er_nombre' => 'VENTAS A TIENDAS'],
            ['nombre' => 'VENTAS PROGRAMAS ESPECIALES', 'orden' => 2, 'concepto_er_nombre' => 'VENTAS PROGRAMAS ESPECIALES'],
            ['nombre' => 'VENTAS NETAS', 'orden' => 3, 'concepto_er_nombre' => 'VENTAS NETAS'],
            ['nombre' => 'COSTO DE VENTA', 'orden' => 4, 'concepto_er_nombre' => 'COSTO DE VENTA'],
            ['nombre' => 'REMANENTE BRUTO', 'orden' => 5, 'concepto_er_nombre' => 'REMANENTE BRUTO'],
            ['nombre' => 'GASTOS DE DISTRIBUCION', 'orden' => 6, 'concepto_er_nombre' => 'GASTOS DE DISTRIBUCION'],
            ['nombre' => 'REMUNERACION Y PREV. SOCIAL', 'orden' => 7, 'concepto_er_nombre' => 'REMUNERACION Y PREV. SOCIAL'],
            ['nombre' => 'SERVICIO A COMUNIDADES', 'orden' => 8, 'concepto_er_nombre' => 'SERVICIO A COMUNIDADES'],
            ['nombre' => 'COMBUSTIBLE Y LUBRICANTES', 'orden' => 9, 'concepto_er_nombre' => 'COMBUSTIBLE Y LUBRICANTES'],
            ['nombre' => 'MTTO CONSV. Y REPARA.', 'orden' => 10, 'concepto_er_nombre' => 'MTTO CONSV. Y REPARA.'],
            ['nombre' => 'MTTO DE EQUIPO DE TRANSP.', 'orden' => 11, 'concepto_er_nombre' => 'MTTO DE EQUIPO DE TRANSP.'],
            ['nombre' => 'FLETES Y MANIOBRAS', 'orden' => 12, 'concepto_er_nombre' => 'FLETES Y MANIOBRAS'],
            ['nombre' => 'ALMACENAJE', 'orden' => 13, 'concepto_er_nombre' => 'ALMACENAJE'],
            ['nombre' => 'DEPRECIACIONES Y AMORTIZACIONES', 'orden' => 14, 'concepto_er_nombre' => 'DEPRECIACIONES Y AMORTIZACIONES'],
            ['nombre' => 'GASTOS DE VIAJE', 'orden' => 15, 'concepto_er_nombre' => 'GASTOS DE VIAJE'],
            ['nombre' => 'MATERIALES Y SERVICIOS DE OFICINA', 'orden' => 16, 'concepto_er_nombre' => 'MATERIALES Y SERVICIOS DE OFICINA'],
            ['nombre' => 'PRIMA DE SEGUROS', 'orden' => 17, 'concepto_er_nombre' => 'PRIMA DE SEGUROS'],
            ['nombre' => 'ESTIMACION PARA CUENTAS INCOBRABLES', 'orden' => 18, 'concepto_er_nombre' => 'ESTIMACION PARA CUENTAS INCOBRABLES'],
            ['nombre' => 'DIVERSOS', 'orden' => 19, 'concepto_er_nombre' => 'DIVERSOS'],
            ['nombre' => 'ASESORIAS', 'orden' => 20, 'concepto_er_nombre' => 'ASESORIAS'],
            ['nombre' => 'IMPUESTOS Y DERECHOS', 'orden' => 21, 'concepto_er_nombre' => 'IMPUESTOS Y DERECHOS'],
            ['nombre' => 'LIQUIDACION', 'orden' => 22, 'concepto_er_nombre' => 'LIQUIDACION'],
            ['nombre' => 'TOTAL DE GTOS DE DISTRIBUCION', 'orden' => 23, 'concepto_er_nombre' => 'TOTAL DE GTOS DE DISTRIBUCION'],
            ['nombre' => 'RESULTADO DIRECTO DE OPERACIÓN', 'orden' => 24, 'concepto_er_nombre' => 'RESULTADO DIRECTO DE OPERACIÓN'],
        ];

        foreach ($conceptos as $concepto) {
            ConceptoMaestro::updateOrCreate(
                ['nombre' => $concepto['nombre'], 'categoria' => 'ER'],
                [
                    'categoria' => 'ER',
                    'orden' => $concepto['orden'],
                    'concepto_er_nombre' => $concepto['concepto_er_nombre'] ?? null,
                ]
            );
        }
    }
}
