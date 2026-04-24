<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ERExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $matriz;
    protected $conceptos;

    public function __construct($matriz, $conceptos)
    {
        $this->matriz = $matriz;
        $this->conceptos = $conceptos;
    }

    public function view(): View
    {
        return view('estado_resultados._tabla', [
            'matriz' => $this->matriz,
            'conceptos' => $this->conceptos
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
