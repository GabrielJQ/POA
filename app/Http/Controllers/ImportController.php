<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ERImport;
use App\Imports\VentasDetalladasImport;
use App\Models\Almacen;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
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

            return redirect()->route('importaciones.index')
                ->with('success', "Estado de Resultados importado para {$anio}.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function importVentas(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv',
            'programa' => 'required|in:PAR,PE',
        ]);

        try {
            $archivo = $request->file('archivo');
            $programa = $request->programa;

            $import = new VentasDetalladasImport($programa);
            Excel::import($import, $archivo);
            
            return redirect()->route('importaciones.index')
                ->with('success', "Ventas del programa {$programa} importadas correctamente.");
        } catch (Exception $e) {
            return redirect()->route('importaciones.index')
                ->with('error', 'Error al importar ventas: ' . $e->getMessage());
        }
    }
}