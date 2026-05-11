<?php

namespace Tests\Feature;

use App\Domain\Services\POADomainService;
use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\ValueObjects\Periodo;
use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class POADomainServiceTest extends TestCase
{
    use RefreshDatabase;

    private POADomainService $service;
    private ConceptoMaestro $oportunidad;
    private ConceptoMaestro $eficiencia;
    private ConceptoMaestro $ventaPar;
    private ConceptoMaestro $erVentas;
    private Almacen $almacen1;
    private Almacen $almacen2;

    protected function setUp(): void
    {
        parent::setUp();

        $regional = \App\Models\Regional::create(['nombre' => 'OAXACA']);
        $uo = \App\Models\UnidadOperativa::create(['regional_id' => $regional->id, 'nombre' => 'VALLES CENTRALES']);

        $this->almacen1 = Almacen::create(['unidad_operativa_id' => $uo->id, 'nombre' => 'ALMACEN CENTRAL OAXACA']);
        $this->almacen2 = Almacen::create(['unidad_operativa_id' => $uo->id, 'nombre' => 'AYUTLA MIXES']);

        $this->erVentas = ConceptoMaestro::create(['nombre' => 'VENTAS A TIENDAS', 'categoria' => 'ER', 'orden' => 1]);

        $this->ventaPar = ConceptoMaestro::create([
            'nombre' => 'PRESUPUESTO DE VENTA PAR', 'categoria' => 'POA', 'orden' => 1,
            'unidad_medida' => 'PESOS', 'concepto_er_nombre' => 'VENTAS A TIENDAS',
        ]);

        $this->oportunidad = ConceptoMaestro::create([
            'nombre' => 'OPORTUNIDAD DE SURTIMIENTO A TIENDAS', 'categoria' => 'POA', 'orden' => 6,
            'unidad_medida' => 'PORCENTAJE',
        ]);

        $this->eficiencia = ConceptoMaestro::create([
            'nombre' => 'EFICIENCIA DE SURTIMIENTO A TIENDAS', 'categoria' => 'POA', 'orden' => 7,
            'unidad_medida' => 'PORCENTAJE',
        ]);

        $this->service = app(POADomainService::class);
    }

    public function test_meta_sums_across_stores(): void
    {
        $erConceptoId = $this->erVentas->id;

        RegistroFinanciero::create([
            'almacen_id' => $this->almacen1->id, 'concepto_id' => $erConceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 1000, 'tipo_dato' => 'META',
        ]);
        RegistroFinanciero::create([
            'almacen_id' => $this->almacen2->id, 'concepto_id' => $erConceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 2000, 'tipo_dato' => 'META',
        ]);
        RegistroFinanciero::create([
            'almacen_id' => $this->almacen1->id, 'concepto_id' => $erConceptoId,
            'mes' => 2, 'anio' => 2026, 'monto' => 3000, 'tipo_dato' => 'META',
        ]);

        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, null, true, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $compromisoId = $this->ventaPar->id;
        $obj1 = $result['dataPoa'][$compromisoId]['COMPROMETIDO'];

        $this->assertEquals(6000, $obj1->meta_anual);
        $this->assertEquals(3000, $obj1->mes_01);
    }

    public function test_percentage_averaged_in_consolidado(): void
    {
        $conceptoId = $this->oportunidad->id;

        RegistroFinanciero::create([
            'almacen_id' => $this->almacen1->id, 'concepto_id' => $conceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 20, 'tipo_dato' => 'REAL',
        ]);
        RegistroFinanciero::create([
            'almacen_id' => $this->almacen2->id, 'concepto_id' => $conceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 40, 'tipo_dato' => 'REAL',
        ]);

        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, null, true, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $obj2 = $result['dataPoa'][$conceptoId]['REALIZADO'];

        $this->assertEquals(30, $obj2->meta_anual);
        $this->assertEquals(30, $obj2->mes_01);
    }

    public function test_single_store_no_averaging(): void
    {
        $conceptoId = $this->oportunidad->id;

        RegistroFinanciero::create([
            'almacen_id' => $this->almacen1->id, 'concepto_id' => $conceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 20, 'tipo_dato' => 'REAL',
        ]);
        RegistroFinanciero::create([
            'almacen_id' => $this->almacen2->id, 'concepto_id' => $conceptoId,
            'mes' => 1, 'anio' => 2026, 'monto' => 40, 'tipo_dato' => 'REAL',
        ]);

        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, $this->almacen1->id, false, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $obj2 = $result['dataPoa'][$conceptoId]['REALIZADO'];

        $this->assertEquals(20, $obj2->meta_anual);
        $this->assertEquals(20, $obj2->mes_01);
    }

    public function test_annual_fallback_when_no_monthly_meta(): void
    {
        $erConceptoId = $this->erVentas->id;

        RegistroFinanciero::create([
            'almacen_id' => $this->almacen1->id, 'concepto_id' => $erConceptoId,
            'mes' => 0, 'anio' => 2026, 'monto' => 12000, 'tipo_dato' => 'META',
        ]);

        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, null, true, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $obj1 = $result['dataPoa'][$this->ventaPar->id]['COMPROMETIDO'];

        $this->assertEquals(12000, $obj1->meta_anual);
        $this->assertEquals(12000, $obj1->mes_01);
    }

    public function test_no_records_returns_zero_defaults(): void
    {
        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, null, true, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $this->assertCount(3, $result['compromisos']);
        $this->assertCount(3, $result['dataPoa']);

        $ventaParRow = $result['dataPoa'][$this->ventaPar->id];
        $this->assertEquals(0, $ventaParRow['COMPROMETIDO']->meta_anual);
        $this->assertEquals(0, $ventaParRow['REALIZADO']->meta_anual);

        $oporRow = $result['dataPoa'][$this->oportunidad->id];
        $this->assertEquals(100, $oporRow['COMPROMETIDO']->meta_anual);
        $this->assertEquals(0, $oporRow['REALIZADO']->meta_anual);

        $efiRow = $result['dataPoa'][$this->eficiencia->id];
        $this->assertEquals(100, $efiRow['COMPROMETIDO']->meta_anual);
        $this->assertEquals(0, $efiRow['REALIZADO']->meta_anual);
    }

    public function test_response_structure(): void
    {
        $periodo = new Periodo('mensual', 1, 1);
        $filtros = new FiltrosPOA(2026, null, true, $periodo);
        $result = $this->service->obtenerDatosPOA($filtros);

        $this->assertArrayHasKey('compromisos', $result);
        $this->assertArrayHasKey('dataPoa', $result);
    }
}
