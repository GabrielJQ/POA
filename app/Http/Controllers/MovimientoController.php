<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovimientoController extends Controller
{
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
