<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Models\Almacen;
use App\Services\POAService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    protected POAService $poaService;

    public function __construct(POAService $poaService)
    {
        $this->poaService = $poaService;
    }

    public function index()
    {
        $almacenes = Almacen::orderBy('nombre')->get();
        return view('importaciones.index', compact('almacenes'));
    }

    public function importER(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        try {
            $anio = (int) $request->anio;
            $archivo = $request->file('archivo');

            Excel::import(new ERImport($anio), $archivo);

            $this->autoSyncPOA($anio);

            return redirect()->route('importaciones.index')
                ->with('success', "Estado de Resultados importado para {$anio}. POA sincronizado automáticamente.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    private function autoSyncPOA(int $anio): void
    {
        $almacenes = Almacen::whereHas('resultadosMensuales', function ($q) use ($anio) {
            $q->where('anio', $anio);
        })->pluck('id');

        foreach ($almacenes as $id) {
            $this->poaService->syncFromER($id, $anio);
        }
    }
}