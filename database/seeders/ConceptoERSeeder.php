<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConceptoMaestro;

class ConceptoERSeeder extends Seeder
{
    public function run(): void
    {
        $conceptos = [
            ['nombre' => 'VENTAS A TIENDAS', 'orden' => 1],
            ['nombre' => 'VENTAS PROGRAMAS ESPECIALES', 'orden' => 2],
            ['nombre' => 'VENTAS NETAS', 'orden' => 3],
            ['nombre' => 'COSTO DE VENTA', 'orden' => 4],
            ['nombre' => 'REMANENTE BRUTO', 'orden' => 5],
            ['nombre' => 'GASTOS DE DISTRIBUCION', 'orden' => 6],
            ['nombre' => 'REMUNERACION Y PREV. SOCIAL', 'orden' => 7],
            ['nombre' => 'SERVICIO A COMUNIDADES', 'orden' => 8],
            ['nombre' => 'COMBUSTIBLE Y LUBRICANTES', 'orden' => 9],
            ['nombre' => 'MTTO CONSV. Y REPARA.', 'orden' => 10],
            ['nombre' => 'MTTO DE EQUIPO DE TRANSP.', 'orden' => 11],
            ['nombre' => 'FLETES Y MANIOBRAS', 'orden' => 12],
            ['nombre' => 'ALMACENAJE', 'orden' => 13],
            ['nombre' => 'DEPRECIACIONES Y AMORTIZACIONES', 'orden' => 14],
            ['nombre' => 'GASTOS DE VIAJE', 'orden' => 15],
            ['nombre' => 'MATERIALES Y SERVICIOS DE OFICINA', 'orden' => 16],
            ['nombre' => 'PRIMA DE SEGUROS', 'orden' => 17],
            ['nombre' => 'ESTIMACION PARA CUENTAS INCOBRABLES', 'orden' => 18],
            ['nombre' => 'DIVERSOS', 'orden' => 19],
            ['nombre' => 'ASESORIAS', 'orden' => 20],
            ['nombre' => 'IMPUESTOS Y DERECHOS', 'orden' => 21],
            ['nombre' => 'LIQUIDACION', 'orden' => 22],
            ['nombre' => 'TOTAL DE GTOS DE DISTRIBUCION', 'orden' => 23],
            ['nombre' => 'RESULTADO DIRECTO DE OPERACIÓN', 'orden' => 24],
        ];

        foreach ($conceptos as $concepto) {
            ConceptoMaestro::updateOrCreate(
                ['nombre' => $concepto['nombre'], 'categoria' => 'ER'],
                ['categoria' => 'ER', 'orden' => $concepto['orden']]
            );
        }
    }
}
