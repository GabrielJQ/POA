<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv',
            'tipo' => 'required'
        ]);

        try {
            \Excel::import(new \App\Imports\MovimientosImport($request->tipo), $request->file('archivo'));
            return back()->with('success', 'La importación de ' . $request->tipo . ' se completó con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error en la importación: ' . $e->getMessage());
        }
    }
}
