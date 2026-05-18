<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class ERImport implements WithMultipleSheets, SkipsUnknownSheets
{
    protected $anio;

    public function __construct($anio)
    {
        $this->anio = $anio;
    }

    public function sheets(): array
    {
        return [];
    }

    public function onUnknownSheet($sheetName)
    {
        return new ERSheetImport($this->anio, $sheetName);
    }
}
