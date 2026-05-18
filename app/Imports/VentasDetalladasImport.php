<?php

namespace App\Imports;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VentasDetalladasImport implements WithMultipleSheets
{
    private array $sheetImports = [];

    public function __construct(
        private int $anio,
        IAlmacenRepository $almacenRepo,
        IConceptoMaestroRepository $conceptoRepo
    ) {
        $lineas = $conceptoRepo->pluckByCategoria('LINEA_PRODUCTO', 'numero', 'id');

        $this->sheetImports = [
            'PAR' => new VentasDetalladasSheetImport($this->anio, 'PAR', $almacenRepo, $conceptoRepo, $lineas),
            'ESP' => new VentasDetalladasSheetImport($this->anio, 'PE', $almacenRepo, $conceptoRepo, $lineas),
        ];
    }

    public function sheets(): array
    {
        return $this->sheetImports;
    }

    public function getUpsertData(): array
    {
        $data = [];
        foreach ($this->sheetImports as $si) {
            $data = array_merge($data, $si->getUpsertData());
        }
        return $data;
    }
}
