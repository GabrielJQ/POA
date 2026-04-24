<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConceptoER;

class ConceptoERSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conceptos = [
            ['nombre' => 'VENTAS A TIENDAS', 'categoria' => 'INGRESOS', 'tipo' => 1, 'orden_visual' => 1, 'es_calculado' => false],
            ['nombre' => 'VENTAS PROGRAMAS ESPECIALES', 'categoria' => 'INGRESOS', 'tipo' => 1, 'orden_visual' => 2, 'es_calculado' => false],
            ['nombre' => 'VENTAS NETAS', 'categoria' => 'INGRESOS', 'tipo' => 1, 'orden_visual' => 3, 'es_calculado' => true],
            ['nombre' => 'COSTO DE VENTA', 'categoria' => 'EGRESOS', 'tipo' => -1, 'orden_visual' => 4, 'es_calculado' => false],
            ['nombre' => 'REMANENTE BRUTO', 'categoria' => 'RESULTADO', 'tipo' => 1, 'orden_visual' => 5, 'es_calculado' => true],
            ['nombre' => 'GASTOS DE DISTRIBUCION', 'categoria' => 'TITULO', 'tipo' => 0, 'orden_visual' => 6, 'es_calculado' => true],
            ['nombre' => 'REMUNERACION Y PREV. SOCIAL', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 7, 'es_calculado' => false],
            ['nombre' => 'SERVICIO A COMUNIDADES', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 8, 'es_calculado' => false],
            ['nombre' => 'COMBUSTIBLE Y LUBRICANTES', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 9, 'es_calculado' => false],
            ['nombre' => 'MTTO CONSV. Y REPARA.', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 10, 'es_calculado' => false],
            ['nombre' => 'MTTO DE EQUIPO DE TRANSP.', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 11, 'es_calculado' => false],
            ['nombre' => 'FLETES Y MANIOBRAS', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 12, 'es_calculado' => false],
            ['nombre' => 'ALMACENAJE', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 13, 'es_calculado' => false],
            ['nombre' => 'DEPRECIACIONES Y AMORTIZACIONES', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 14, 'es_calculado' => false],
            ['nombre' => 'GASTOS DE VIAJE', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 15, 'es_calculado' => false],
            ['nombre' => 'MATERIALES Y SERVICIOS DE OFICINA', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 16, 'es_calculado' => false],
            ['nombre' => 'PRIMA DE SEGUROS', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 17, 'es_calculado' => false],
            ['nombre' => 'ESTIMACION PARA CUENTAS INCOBRABLES', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 18, 'es_calculado' => false],
            ['nombre' => 'DIVERSOS', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 19, 'es_calculado' => false],
            ['nombre' => 'ASESORIAS', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 20, 'es_calculado' => false],
            ['nombre' => 'IMPUESTOS Y DERECHOS', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 21, 'es_calculado' => false],
            ['nombre' => 'LIQUIDACION', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 22, 'es_calculado' => false],
            ['nombre' => 'TOTAL DE GTOS DE DISTRIBUCION', 'categoria' => 'GASTOS_DIST', 'tipo' => -1, 'orden_visual' => 23, 'es_calculado' => true],
            ['nombre' => 'RESULTADO DIRECTO DE OPERACIÓN', 'categoria' => 'RESULTADO', 'tipo' => 1, 'orden_visual' => 24, 'es_calculado' => true],
        ];

        foreach ($conceptos as $concepto) {
            ConceptoER::updateOrCreate(
                ['nombre' => $concepto['nombre']],
                $concepto
            );
        }
    }
}
