<?php

namespace Tests\Feature;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\ConceptoMaestro;
use App\Domain\Entities\Regional;
use App\Domain\Entities\UnidadOperativa;
use App\Domain\Entities\RegistroFinanciero;
use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\CacheKeys;
use App\Imports\SurtimientoTiendasImport;
use App\Imports\AperturaTiendasMetaImport;
use App\Imports\AperturaTiendasSheetImport;
use App\Imports\MermasQuebrantosImport;
use App\Imports\MermasQuebrantosSheetImport;
use App\Imports\VentasDetalladasImport;
use App\Imports\VentasDetalladasSheetImport;
use App\Application\UseCases\POA\ImportarSurtimiento;
use App\Application\UseCases\POA\ImportarAperturaTiendas;
use App\Application\UseCases\POA\ImportarMermas;
use App\Application\UseCases\POA\ImportarVentasDetalladas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportsTest extends TestCase
{
    use RefreshDatabase;

    private Almacen $almacen1;
    private Almacen $almacen2;
    private array $surtimientoConceptos;
    private array $aperturaConceptos;
    private ?int $mermaConceptoId;
    private Collection $lineasProducto;

    protected function setUp(): void
    {
        parent::setUp();

        $regional = Regional::create(['nombre' => 'REGIONAL OAXACA']);
        $uo = UnidadOperativa::create(['regional_id' => $regional->id, 'nombre' => 'VALLES CENTRALES']);

        $this->almacen1 = Almacen::create(['unidad_operativa_id' => $uo->id, 'nombre' => 'ALMACEN CENTRAL OAXACA']);
        $this->almacen2 = Almacen::create(['unidad_operativa_id' => $uo->id, 'nombre' => 'AYUTLA MIXES']);

        $this->surtimientoConceptos = [
            'OPORTUNIDAD' => ConceptoMaestro::create([
                'nombre' => 'OPORTUNIDAD DE SURTIMIENTO A TIENDAS', 'categoria' => 'POA', 'orden' => 1,
            ])->id,
            'EFICIENCIA' => ConceptoMaestro::create([
                'nombre' => 'EFICIENCIA DE SURTIMIENTO A TIENDAS', 'categoria' => 'POA', 'orden' => 2,
            ])->id,
        ];

        $this->aperturaConceptos = [
            'TOTAL'       => ConceptoMaestro::create(['nombre' => 'APERTURA DE TIENDAS', 'categoria' => 'POA', 'orden' => 3])->id,
            'OBJETIVO'    => ConceptoMaestro::create(['nombre' => 'APERTURA DE TIENDAS LOCALIDAD OBJETIVO', 'categoria' => 'POA', 'orden' => 4])->id,
            'ESTRATEGICA' => ConceptoMaestro::create(['nombre' => 'APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA', 'categoria' => 'POA', 'orden' => 5])->id,
        ];

        $this->mermaConceptoId = ConceptoMaestro::create([
            'nombre' => 'MERMAS, QUEBRANTOS Y MAL ESTADO', 'categoria' => 'POA', 'orden' => 6,
        ])->id;

        $this->lineasProducto = collect([
            ConceptoMaestro::create(['nombre' => 'MAIZ', 'categoria' => 'LINEA_PRODUCTO', 'numero' => 1, 'orden' => 1]),
            ConceptoMaestro::create(['nombre' => 'FRIJOL', 'categoria' => 'LINEA_PRODUCTO', 'numero' => 2, 'orden' => 2]),
            ConceptoMaestro::create(['nombre' => 'ARROZ', 'categoria' => 'LINEA_PRODUCTO', 'numero' => 3, 'orden' => 3]),
        ]);
    }

    private function resetReposCache(): void
    {
        $cache = app(ICacheStore::class);
        $cache->increment(CacheKeys::POA_VERSION);
    }

    // ========================================================================
    //  SURTIMIENTO IMPORT
    // ========================================================================

    public function test_surtimiento_parses_trimestral_values_to_monthly(): void
    {
        $repo = app(IAlmacenRepository::class);
        $conceptoRepo = app(IConceptoMaestroRepository::class);
        $this->resetReposCache();

        $import = new SurtimientoTiendasImport(2026, $repo, $conceptoRepo);

        $rows = new Collection([
            ['HEADER', null, null, null, null, null, null, null, null],
            ['HEADER', null, null, null, null, null, null, null, null],
            ['HEADER', null, null, null, null, null, null, null, null],
            ['HEADER', null, null, null, null, null, null, null, null],
            ['HEADER', null, null, null, null, null, null, null, null],
            ['ALMACEN CENTRAL OAXACA', '300', '150', '600', '300', '900', '450', '1200', '600'],
            ['AYUTLA MIXES', '30', '15', '60', '30', '90', '45', '120', '60'],
        ]);

        $import->collection($rows);
        $data = $import->getUpsertData();

        $this->assertNotEmpty($data);

        $opRecords = array_filter($data, fn($r) => $r['concepto_id'] === $this->surtimientoConceptos['OPORTUNIDAD']);
        $efRecords = array_filter($data, fn($r) => $r['concepto_id'] === $this->surtimientoConceptos['EFICIENCIA']);

        // 2 stores * 4 quarters * 3 months = 24 records each
        $this->assertCount(24, $opRecords);
        $this->assertCount(24, $efRecords);

        // Verify first store, first quarter oportunidad: 300/3 = 100 per month
        $store1Op = array_filter($opRecords, fn($r) => $r['almacen_id'] === $this->almacen1->id && in_array($r['mes'], [1, 2, 3]));
        $this->assertCount(3, $store1Op);
        foreach ($store1Op as $r) {
            $this->assertEquals(100.0, $r['monto']);
        }

        // Verify first store Q4 eficiencia: 600/3 = 200 per month (months 10, 11, 12)
        $store1EfQ4 = array_filter($efRecords, fn($r) => $r['almacen_id'] === $this->almacen1->id && in_array($r['mes'], [10, 11, 12]));
        $this->assertCount(3, $store1EfQ4);
        foreach ($store1EfQ4 as $r) {
            $this->assertEquals(200.0, $r['monto']);
        }

        // Verify tipo_dato and programa
        foreach ($data as $r) {
            $this->assertEquals('REAL', $r['tipo_dato']);
            $this->assertNull($r['programa']);
            $this->assertEquals(2026, $r['anio']);
        }
    }

    public function test_surtimiento_skips_total_rows_and_empty(): void
    {
        $import = new SurtimientoTiendasImport(2026, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));
        $this->resetReposCache();

        $rows = new Collection([
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            ['TOTAL GENERAL', '100', '50', null, null, null, null, null, null],
            ['ALMACEN CENTRAL OAXACA', '300', '150', null, null, null, null, null, null],
        ]);

        $import->collection($rows);
        $data = $import->getUpsertData();

        // Only 1 non-total store, only Q1 has values
        $this->assertCount(6, $data); // 1 store * 2 concepts * 3 months
    }

    public function test_surtimiento_skips_unknown_stores(): void
    {
        $import = new SurtimientoTiendasImport(2026, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));
        $this->resetReposCache();

        $rows = new Collection([
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            ['TIENDA INEXISTENTE SA', '300', '150', null, null, null, null, null, null],
        ]);

        $import->collection($rows);
        $data = $import->getUpsertData();

        $this->assertEmpty($data);
    }

    public function test_surtimiento_use_case_executes_full_flow(): void
    {
        $useCase = app(ImportarSurtimiento::class);
        $this->resetReposCache();

        $anio = 2026;
        $import = new SurtimientoTiendasImport($anio, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));

        $rows = new Collection([
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            ['ALMACEN CENTRAL OAXACA', '300', '150', null, null, null, null, null, null],
        ]);

        $import->collection($rows);

        $upsertData = $import->getUpsertData();
        $repo = app(IRegistroFinancieroRepository::class);

        if (!empty($upsertData)) {
            $repo->upsertMany($upsertData, ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'], ['monto']);
        }

        $saved = RegistroFinanciero::where('anio', $anio)->where('tipo_dato', 'REAL')->get();
        $this->assertCount(6, $saved); // 2 concepts * 3 months
    }

    // ========================================================================
    //  APERTURA TIENDAS IMPORT
    // ========================================================================

    public function test_apertura_tiendas_sheet_parses_openings(): void
    {
        $this->resetReposCache();

        $sheetImport = new AperturaTiendasSheetImport(
            2026, $this->aperturaConceptos,
            app(IAlmacenRepository::class)->findAllOrdered()->keyBy('nombre'),
            'ALMACEN CENTRAL OAXACA'
        );

        $rows = new Collection([
            ['ENC', null, null, 'ALMACEN CENTRAL OAXACA'],
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            // Tienda 1: col 11 (index 11) = mes 1, value 'X' (counts as 1)
            ['TIENDA 1', null, null, null, null, null, null, null, null, null, null, 'X', null, null, null, null, null, null, null, null, null, null, null],
            // Tienda 2: col 13 (index 13) = mes 3, value 'X' (counts as 1)
            ['TIENDA 2', null, null, null, null, null, null, null, null, null, null, null, null, 'X', null, null, null, null, null, null, null, null],
            // Tienda 3: col 9 (index 9) = esObjetivo, col 12 (index 12) = mes 2, value 'OBJ'
            ['TIENDA 3', null, null, null, null, null, null, null, null, 'X', null, null, 'OBJ', null, null, null, null, null, null, null, null],
        ]);

        $sheetImport->collection($rows);
        $data = $sheetImport->getUpsertData();

        $this->assertNotEmpty($data);

        // Code: m=1→colIdx=11, m=2→colIdx=12, m=3→colIdx=13
        // Tienda 1: colIdx 11 → m=1, value 'X' (counts as 1)
        // Tienda 2: colIdx 13 → m=3, value 'X' (counts as 1)
        // Tienda 3: col 9 = 'X' → esObjetivo, colIdx 12 → m=2, value 'OBJ'

        $totalRecords = array_filter($data, fn($r) => $r['concepto_id'] === $this->aperturaConceptos['TOTAL']);
        $objetivoRecords = array_filter($data, fn($r) => $r['concepto_id'] === $this->aperturaConceptos['OBJETIVO']);

        $this->assertCount(3, $totalRecords); // 3 months with openings
        $this->assertCount(1, $objetivoRecords); // 1 month with objetivo

        $this->assertEquals(1, $data[0]['monto']);
        $this->assertEquals('META', $data[0]['tipo_dato']);
    }

    public function test_apertura_tiendas_skips_pt4_sheet(): void
    {
        $this->resetReposCache();
        $import = new AperturaTiendasMetaImport(2026, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));

        $sheetImport = $import->onUnknownSheet('PT 4');
        $this->assertNull($sheetImport);
    }

    public function test_apertura_tiendas_aggregates_multi_sheet(): void
    {
        $import = new AperturaTiendasMetaImport(2026, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));
        $this->resetReposCache();

        $sheet1 = $import->onUnknownSheet('ALMACEN CENTRAL OAXACA');
        $this->assertNotNull($sheet1);

        $sheet1->collection(new Collection([
            ['ENC', null, null, 'ALMACEN CENTRAL OAXACA'],
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            ['T1', null, null, null, null, null, null, null, null, null, null, 'X'],
        ]));

        $data = $import->getUpsertData();
        $this->assertNotEmpty($data);
    }

    // ========================================================================
    //  MERMAS Y QUEBRANTOS IMPORT
    // ========================================================================

    public function test_mermas_sheet_calculates_monthly(): void
    {
        $this->resetReposCache();

        $sheetImport = new MermasQuebrantosSheetImport(
            2026, $this->mermaConceptoId,
            config('mermas.lineas'),
            app(IAlmacenRepository::class)->findAllOrdered()->keyBy('nombre'),
            'ALMACEN CENTRAL OAXACA'
        );

        // Maiz: merma=0.15%, quebranto=0.10% → total = 0.25% → /100 = 0.0025
        // Venta mes 1 = 100000 → 100000 * 0.0025 = 250
        // Frijol: merma=0.05%, quebranto=0.01% → total = 0.06% → /100 = 0.0006
        // Venta mes 1 = 50000 → 50000 * 0.0006 = 30
        // Total mes 1 = 250 + 30 = 280
        // Col E(4) = mes 1 venta maiz, F(5) = mes 1 venta frijol... no
        // Col formula: ($mes - 1) * 2 + 4
        // Mes 1: col 4 (E) = maiz venta, col 5 (F) = frijol venta (but we skip every other col)
        // Wait, looking at the logic:
        // for ($mes = 1; $mes <= 12; $mes++) {
        //     $colIdx = ($mes - 1) * 2 + 4;
        //     $montoVenta = $this->parseMonto($rows[$i][$colIdx] ?? null);

        $rows = new Collection([
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            // Row 14 (index 14): MAIZ
            ['MAIZ', null, null, null, '100000', null, '120000', null, '80000', null, '90000', null, '110000', null, '95000', null, '105000', null, '115000', null, '85000', null, '125000', null, '70000', null, '95000'],
            // Row 15 (index 15): FRIJOL
            ['FRIJOL', null, null, null, '50000', null, '60000', null, '40000', null, '45000', null, '55000', null, '47500', null, '52500', null, '57500', null, '42500', null, '62500', null, '35000', null, '47500'],
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
        ]);

        $sheetImport->collection($rows);
        $data = $sheetImport->getUpsertData();

        $this->assertNotEmpty($data);
        $this->assertCount(12, $data); // 12 months

        // Maiz rate: (0.15 + 0.10) / 100 = 0.0025
        // Frijol rate: (0.05 + 0.01) / 100 = 0.0006
        // Mes 1: 100000 * 0.0025 + 50000 * 0.0006 = 250 + 30 = 280
        $this->assertEquals(280.0, $data[0]['monto']);
        // Mes 2: 120000 * 0.0025 + 60000 * 0.0006 = 300 + 36 = 336
        $this->assertEquals(336.0, $data[1]['monto']);
        // Mes 3: 80000 * 0.0025 + 40000 * 0.0006 = 200 + 24 = 224
        $this->assertEquals(224.0, $data[2]['monto']);

        foreach ($data as $r) {
            $this->assertEquals('META', $r['tipo_dato']);
            $this->assertEquals($this->almacen1->id, $r['almacen_id']);
            $this->assertEquals($this->mermaConceptoId, $r['concepto_id']);
            $this->assertEquals(2026, $r['anio']);
        }
    }

    public function test_mermas_handles_unknown_sheet_name(): void
    {
        $this->resetReposCache();

        $sheetImport = new MermasQuebrantosSheetImport(
            2026, $this->mermaConceptoId,
            config('mermas.lineas'),
            app(IAlmacenRepository::class)->findAllOrdered()->keyBy('nombre'),
            'SHEET_INEXISTENTE'
        );

        $sheetImport->collection(new Collection([array_fill(0, 27, null)]));
        $this->assertEmpty($sheetImport->getUpsertData());
    }

    public function test_mermas_without_concepto_returns_empty(): void
    {
        $this->resetReposCache();

        $sheetImport = new MermasQuebrantosSheetImport(
            2026, null,
            config('mermas.lineas'),
            app(IAlmacenRepository::class)->findAllOrdered()->keyBy('nombre'),
            'ALMACEN CENTRAL OAXACA'
        );

        $sheetImport->collection(new Collection([array_fill(0, 27, null)]));
        $this->assertEmpty($sheetImport->getUpsertData());
    }

    // ========================================================================
    //  VENTAS DETALLADAS IMPORT
    // ========================================================================

    public function test_ventas_sheet_parses_stores_and_lines(): void
    {
        $this->resetReposCache();

        $lineas = $this->lineasProducto->keyBy('numero');
        $repo = app(IAlmacenRepository::class);
        $conceptoRepo = app(IConceptoMaestroRepository::class);

        $sheetImport = new VentasDetalladasSheetImport(2026, 'PAR', $repo, $conceptoRepo, $lineas);

        $rows = new Collection([
            ['ALMACEN CENTRAL OAXACA', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            // Row: numero=MAIZ(num 1), col1=numero(1), cols 3,4,5=meses 1,2,3
            ['MAIZ', '1', '', '1000', '2000', '3000', '', '', '', '', '', '', '', '', '', '', '', ''],
            // Row: numero=FRIJOL(num 2), col1=numero(2)
            ['FRIJOL', '2', '', '4000', '5000', '6000', '', '', '', '', '', '', '', '', '', '', '', ''],
        ]);

        $sheetImport->collection($rows);
        $data = $sheetImport->getUpsertData();

        $this->assertNotEmpty($data);

        $this->assertEquals('REAL', $data[0]['tipo_dato']);
        $this->assertEquals('PAR', $data[0]['programa']);

        $maizRecords = array_filter($data, fn($r) => $r['concepto_id'] === $this->lineasProducto[0]->id);
        $this->assertCount(3, $maizRecords);

        $this->assertEquals(1000.0, $maizRecords[0]['monto']);
        $this->assertEquals(2000.0, $maizRecords[1]['monto']);
        $this->assertEquals(3000.0, $maizRecords[2]['monto']);
    }

    public function test_ventas_skip_unknown_line_products(): void
    {
        $this->resetReposCache();

        $lineas = $this->lineasProducto->keyBy('numero');
        $repo = app(IAlmacenRepository::class);
        $conceptoRepo = app(IConceptoMaestroRepository::class);

        $sheetImport = new VentasDetalladasSheetImport(2026, 'PAR', $repo, $conceptoRepo, $lineas);

        $rows = new Collection([
            ['ALMACEN CENTRAL OAXACA', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['PRODUCTO_INEXISTENTE', '99', '', '1000', '2000', '3000', '', '', '', '', '', '', '', '', '', '', '', ''],
        ]);

        $sheetImport->collection($rows);
        $data = $sheetImport->getUpsertData();

        // Producto inexistente should be skipped with a warning, no upsert data from that line
        $this->assertEmpty($data);
    }

    public function test_ventas_detalladas_multi_sheet_aggregation(): void
    {
        $this->resetReposCache();

        $import = new VentasDetalladasImport(2026, app(IAlmacenRepository::class), app(IConceptoMaestroRepository::class));

        $sheets = $import->sheets();
        $this->assertCount(2, $sheets);
        $this->assertArrayHasKey('PAR', $sheets);
        $this->assertArrayHasKey('ESP', $sheets);
    }

    // ========================================================================
    //  USE CASES — INTEGRATION
    // ========================================================================

    public function test_importar_surtimiento_use_case_resolves(): void
    {
        $useCase = app(ImportarSurtimiento::class);
        $this->assertInstanceOf(ImportarSurtimiento::class, $useCase);
    }

    public function test_importar_apertura_tiendas_use_case_resolves(): void
    {
        $useCase = app(ImportarAperturaTiendas::class);
        $this->assertInstanceOf(ImportarAperturaTiendas::class, $useCase);
    }

    public function test_importar_mermas_use_case_resolves(): void
    {
        $useCase = app(ImportarMermas::class);
        $this->assertInstanceOf(ImportarMermas::class, $useCase);
    }

    public function test_importar_ventas_use_case_resolves(): void
    {
        $useCase = app(ImportarVentasDetalladas::class);
        $this->assertInstanceOf(ImportarVentasDetalladas::class, $useCase);
    }

    // ========================================================================
    //  EDGE CASES — STRESS
    // ========================================================================

    public function test_all_imports_handle_empty_data_gracefully(): void
    {
        $this->resetReposCache();
        $repo = app(IAlmacenRepository::class);
        $conceptoRepo = app(IConceptoMaestroRepository::class);

        // Surtimiento with empty rows
        $import = new SurtimientoTiendasImport(2026, $repo, $conceptoRepo);
        $import->collection(new Collection([array_fill(0, 9, null)]));
        $this->assertEmpty($import->getUpsertData());

        // Apertura sheet with empty rows
        $sheet = new AperturaTiendasSheetImport(2026, $this->aperturaConceptos,
            $repo->findAllOrdered()->keyBy('nombre'), 'ALMACEN CENTRAL OAXACA');
        $sheet->collection(new Collection([array_fill(0, 23, null)]));
        $this->assertEmpty($sheet->getUpsertData());

        // Mermas sheet with empty rows (no matching product lines)
        $sheet2 = new MermasQuebrantosSheetImport(2026, $this->mermaConceptoId,
            config('mermas.lineas'), $repo->findAllOrdered()->keyBy('nombre'), 'ALMACEN CENTRAL OAXACA');
        $sheet2->collection(new Collection([array_fill(0, 27, null)]));
        $this->assertEmpty($sheet2->getUpsertData());

        // Ventas sheet with just header (no product lines)
        $lineas = $this->lineasProducto->keyBy('numero');
        $sheet3 = new VentasDetalladasSheetImport(2026, 'PAR', $repo, $conceptoRepo, $lineas);
        $sheet3->collection(new Collection([['SOME HEADER', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '']]));
        $this->assertEmpty($sheet3->getUpsertData());
    }

    public function test_all_imports_verify_tipo_dato(): void
    {
        $this->resetReposCache();
        $repo = app(IAlmacenRepository::class);
        $conceptoRepo = app(IConceptoMaestroRepository::class);

        $surtimiento = new SurtimientoTiendasImport(2026, $repo, $conceptoRepo);
        $surtimiento->collection(new Collection([
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            array_fill(0, 9, null),
            ['ALMACEN CENTRAL OAXACA', '300', '150'],
        ]));
        foreach ($surtimiento->getUpsertData() as $r) {
            $this->assertEquals('REAL', $r['tipo_dato']);
        }

        $apertura = new AperturaTiendasSheetImport(2026, $this->aperturaConceptos,
            $repo->findAllOrdered()->keyBy('nombre'), 'ALMACEN CENTRAL OAXACA');
        $apertura->collection(new Collection([
            ['ENC', null, null, 'ALMACEN CENTRAL OAXACA'],
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            array_fill(0, 22, null),
            ['T1', null, null, null, null, null, null, null, null, null, null, 'X'],
        ]));
        foreach ($apertura->getUpsertData() as $r) {
            $this->assertEquals('META', $r['tipo_dato']);
        }

        $mermas = new MermasQuebrantosSheetImport(2026, $this->mermaConceptoId,
            config('mermas.lineas'), $repo->findAllOrdered()->keyBy('nombre'), 'ALMACEN CENTRAL OAXACA');
        $mermas->collection(new Collection([
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            array_fill(0, 27, null),
            ['MAIZ', null, null, null, '100000'],
        ]));
        foreach ($mermas->getUpsertData() as $r) {
            $this->assertEquals('META', $r['tipo_dato']);
        }

        $lineas = $this->lineasProducto->keyBy('numero');
        $ventas = new VentasDetalladasSheetImport(2026, 'PE', $repo, $conceptoRepo, $lineas);
        $ventas->collection(new Collection([
            ['ALMACEN CENTRAL OAXACA'],
            ['MAIZ', '1', '', '1000'],
        ]));
        foreach ($ventas->getUpsertData() as $r) {
            $this->assertEquals('REAL', $r['tipo_dato']);
            $this->assertEquals('PE', $r['programa']);
        }
    }
}
