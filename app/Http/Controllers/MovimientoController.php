<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovimientoController extends Controller
{
    /**
     * Importar movimientos de capital (Excel)
     *
     * Procesa un archivo Excel con movimientos de capital (altas/bajas)
     * y los guarda en la tabla movimientos_capital.
     *
     * @group Movimientos
     *
     * @bodyParam archivo file required Archivo Excel (.xlsx, .xls, .csv) hasta 100MB.
     * @bodyParam tipo string required Tipo de movimiento.
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv|max:102400',
            'tipo' => 'required'
        ]);

        try {
            \Excel::import(new \App\Imports\MovimientosImport($request->tipo), $request->file('archivo'));
            Log::info("[Movimiento] Importación de {$request->tipo} completada.");
            return back()->with('success', 'La importación de ' . $request->tipo . ' se completó con éxito.');
        } catch (\Exception $e) {
            Log::error("[Movimiento] Error importación {$request->tipo}: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error en la importación: ' . $e->getMessage());
        }
    }
}
