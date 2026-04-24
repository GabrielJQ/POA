<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompromisoPoa;

class CompromisosPoaSeeder extends Seeder
{
    /**
     * Siembra los compromisos del formato POA oficial.
     * concepto_er_nombre: si tiene valor, se mapeará automáticamente desde el ER.
     */
    public function run(): void
    {
        $compromisos = [
            [
                'nombre' => 'PRESUPUESTO DE VENTA PAR',
                'unidad_medida' => 'PESOS',
                'orden' => 1,
                'concepto_er_nombre' => 'VENTAS A TIENDAS',
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'PRESUPUESTO DE VENTA PE',
                'unidad_medida' => 'PESOS',
                'orden' => 2,
                'concepto_er_nombre' => 'VENTAS PROGRAMAS ESPECIALES',
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'PRESUPUESTO DE VENTA TOTAL',
                'unidad_medida' => 'PESOS',
                'orden' => 3,
                'concepto_er_nombre' => 'VENTAS NETAS',
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'RESULTADO DIRECTO DE OPERACIÓN',
                'unidad_medida' => 'PESOS',
                'orden' => 4,
                'concepto_er_nombre' => 'RESULTADO DIRECTO DE OPERACIÓN',
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'GASTOS DE OPERACIÓN',
                'unidad_medida' => 'PESOS',
                'orden' => 5,
                'concepto_er_nombre' => 'TOTAL DE GTOS DE DISTRIBUCION',
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'OPORTUNIDAD DE SURTIMIENTO A TIENDAS',
                'unidad_medida' => 'PORCENTAJE',
                'orden' => 6,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'EFICIENCIA DE SURTIMIENTO A TIENDAS',
                'unidad_medida' => 'PORCENTAJES',
                'orden' => 7,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'MERMAS, QUEBRANTOS Y MAL ESTADO',
                'unidad_medida' => 'PESOS',
                'orden' => 8,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'APERTURA DE TIENDAS',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 9,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'APERTURA DE TIENDAS LOCALIDAD OBJETIVO',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 10,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 11,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'REACTIVACIÓN DE TIENDAS CON ROTACIÓN CERO Y MENOR A UNA VUELTA',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 12,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'SANEAMIENTO EN TIENDAS COMUNITARIAS',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 13,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'TIENDAS A SANEAR',
                'label_fila_2' => 'TIENDAS SANEADAS',
            ],
            [
                'nombre' => 'RECUPERACIÓN DE FALTANTES DE CAPITAL DE TRABAJO DE TIENDAS',
                'unidad_medida' => 'PESOS',
                'orden' => 14,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'IMPORTE A RECUPERAR',
                'label_fila_2' => 'IMPORTE RECUPERADO',
            ],
            [
                'nombre' => 'CONVERSIÓN DE TIENDAS A U.S.C.',
                'unidad_medida' => 'NÚMERO DE TIENDAS',
                'orden' => 15,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'RENOVACIÓN DE COMITES DE ABASTO',
                'unidad_medida' => 'NÚMERO DE C.A.',
                'orden' => 16,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
            [
                'nombre' => 'RENOVACIÓN M.D. DEL C.C.A. A.C.',
                'unidad_medida' => 'NÚMERO DE C.C.A.',
                'orden' => 17,
                'concepto_er_nombre' => null,
                'label_fila_1' => 'COMPROMETIDO',
                'label_fila_2' => 'REALIZADO',
            ],
        ];

        foreach ($compromisos as $compromiso) {
            CompromisoPoa::updateOrCreate(
                ['nombre' => $compromiso['nombre']],
                $compromiso
            );
        }
    }
}
