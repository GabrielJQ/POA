<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ERImport implements WithMultipleSheets
{
    protected $anio;

    public function __construct($anio)
    {
        $this->anio = $anio;
    }

    public function sheets(): array
    {
        // Usamos un objeto que maneje todas las hojas dinámicamente
        // En Laravel Excel, si no definimos índices, podemos usar el evento 
        // o simplemente procesar todas si implementamos ToCollection en el objeto de la hoja.
        
        // Pero para tener control total, vamos a usar una técnica donde ERSheetImport 
        // se encarga de cada hoja.
        
        return [
            // Procesaremos todas las hojas. 
            // Si queremos procesar todas sin saber los nombres, 
            // usamos SkipsUnknownSheets o simplemente registramos un handler global.
            // Una forma común es usar el índice de la hoja.
        ];
    }
}
