<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\POA\ObtenerDatosPOA;
use App\Application\UseCases\POA\SincronizarPOA;
use App\Exports\POAExportService;
use App\Models\Almacen;
use App\Models\PoaNota;
use Illuminate\Support\Facades\Cache as CacheFacade;

class PoaController extends Controller
{
    private ObtenerDatosPOA $obtenerDatosPOA;
    private SincronizarPOA $sincronizarPOA;
    private POAExportService $exportService;

    public function __construct(
        ObtenerDatosPOA $obtenerDatosPOA,
        SincronizarPOA $sincronizarPOA,
        POAExportService $exportService
    ) {
        $this->obtenerDatosPOA = $obtenerDatosPOA;
        $this->sincronizarPOA = $sincronizarPOA;
        $this->exportService = $exportService;
    }

    /**
     * Mostrar POA
     *
     * Renderiza la tabla del Programa Anual de Trabajo con filtros por
     * almacén, año, período (mensual/trimestral/anual). Soporta consolidado
     * (todas las tiendas) o vista individual por almacén.
     * Si la petición es AJAX, devuelve solo el HTML de la tabla.
     *
     * @group POA
     *
     * @queryParam anio int Año (default: año actual).
     * @queryParam almacen_id int ID del almacén (opcional, para vista individual).
     * @queryParam consolidado string "si" o "no" (default: "si").
     * @queryParam periodo string "mensual", "trimestral" o "anual" (default: "mensual").
     * @queryParam mes int Mes (1-12, default: mes actual).
     * @queryParam trimestre int Trimestre (1-4).
     */
    public function index(Request $request)
    {
        $data = $this->obtenerDatosPOA->execute($request->all());

        if ($request->ajax() === true || $request->expectsJson()) {
            return view('poa._tabla', [
                'compromisos' => $data['compromisos'],
                'dataPoa' => $data['dataPoa'],
                'periodoTipo' => $data['periodoTipo'],
                'labelPeriodo' => $data['labelPeriodo'],
                'config' => $data['config'],
                'meses' => $data['meses'],
                'anioSeleccionado' => $data['anioSeleccionado'],
                'almacenSeleccionado' => $data['almacenSeleccionado'],
                'mostrarConsolidado' => $data['mostrarConsolidado'] ?? true,
            ])->render();
        }

        $almacenes = CacheFacade::remember('almacenes_ordenados', 86400, fn() =>
            Almacen::orderBy('nombre')->get()
        );

        return view('poa.index', array_merge($data, [
            'almacenes' => $almacenes,
            'trimestres' => [
                1 => 'ENE-MAR', 2 => 'ABR-JUN', 3 => 'JUL-SEP', 4 => 'OCT-DIC',
            ],
        ]));
    }

    /**
     * Exportar POA (Excel/PDF)
     *
     * Descarga el POA en formato Excel (.xlsx) con plantilla predefinida
     * o PDF. Incluye metas comprometidas, realizadas, avance del período,
     * % de logro y notas aclaratorias.
     *
     * @group POA
     *
     * @queryParam tipo string "xlsx" o "pdf" (default: "xlsx").
     * @queryParam anio int Año.
     * @queryParam almacen_id int ID del almacén.
     * @queryParam consolidado string "si" o "no".
     * @queryParam periodo string "mensual", "trimestral" o "anual".
     * @queryParam trimestre int Trimestre (1-4).
     * @queryParam mes int Mes (1-12).
     */
    public function export(Request $request)
    {
        $tipo = $request->input('tipo', 'xlsx');

        if (!in_array($tipo, ['xlsx', 'pdf'])) {
            abort(400, 'Tipo de exportación no válido. Use xlsx o pdf.');
        }

        $data = $this->obtenerDatosPOA->executeParaVista($request->all());

        $filters = [
            'tipo' => $tipo,
            'anio' => $request->input('anio', date('Y')),
            'almacenSeleccionado' => $request->input('almacen_id'),
            'mostrarConsolidado' => ($request->input('consolidado', 'si') === 'si'),
            'periodo' => $request->input('periodo', 'mensual'),
            'trimestre' => $request->input('trimestre', 1),
            'mes' => $request->input('mes', date('m')),
        ];

        $data['labelPeriodo'] = $data['labelPeriodo'] ?? 'ENERO';

        return $this->exportService->download($tipo, $data, $filters);
    }

    /**
     * Guardar nota aclaratoria
     *
     * Guarda o actualiza una nota aclaratoria para un concepto, almacén,
     * año y período específicos. Soporta notas por mes, trimestre o anual.
     *
     * @group POA
     *
     * @bodyParam concepto_id int required ID del concepto maestro.
     * @bodyParam label string required Label de la fila (ej. "COMPROMETIDO", "REALIZADO").
     * @bodyParam anio int required Año (2000-2100).
     * @bodyParam nota_aclaratoria string Texto de la nota (max 500 caracteres).
     * @bodyParam almacen_id int ID del almacén (opcional, null = consolidado).
     * @bodyParam mes int required Mes del período (1-12, 101-104 para trimestre, 0 para anual).
     */
    public function saveNota(Request $request)
    {
        $validated = $request->validate([
            'concepto_id' => 'required|integer|exists:conceptos_maestros,id',
            'label' => 'required|string|max:50',
            'anio' => 'required|integer|min:2000|max:2100',
            'nota_aclaratoria' => 'nullable|string|max:500',
            'almacen_id' => 'nullable|integer|exists:almacenes,id',
            'mes' => 'required|integer|min:0|max:200',
        ]);

        PoaNota::updateOrCreate(
            [
                'concepto_id' => (int) $validated['concepto_id'],
                'label' => $validated['label'],
                'anio' => (int) $validated['anio'],
                'almacen_id' => !empty($validated['almacen_id']) ? (int) $validated['almacen_id'] : null,
                'mes' => (int) $validated['mes'],
            ],
            ['nota_aclaratoria' => $validated['nota_aclaratoria'] ?? '']
        );

        CacheFacade::rememberForever('poa_cache_version', fn() => 0);
        CacheFacade::increment('poa_cache_version');

        return response()->json(['success' => true]);
    }

    /**
     * Sincronizar metas POA desde ER
     *
     * Sincroniza las metas del POA desde los registros META del Estado de Resultados
     * para un año y almacén específicos. Si no se especifica almacén,
     * sincroniza todos los almacenes con datos.
     *
     * @group POA
     *
     * @bodyParam anio int required Año (2000-2100).
     * @bodyParam almacen_id int ID del almacén (opcional).
     */
    public function sync(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        $anio = (int) $request->anio;
        $almacenId = $request->input('almacen_id');

        try {
            $result = $this->sincronizarPOA->execute($anio, $almacenId ? (int) $almacenId : null);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $result['message'], 'success' => true]);
            }

            return redirect()->route('poa.index', [
                'anio' => $anio,
                'almacen_id' => $almacenId,
            ])->with('success', $result['message']);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => $e->getMessage(), 'success' => false], 500);
            }
            return redirect()->back()
                ->with('error', 'Error al sincronizar: ' . $e->getMessage());
        }
    }
}