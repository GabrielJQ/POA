<?php

namespace App\Imports;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class AperturaTiendasMetaImport implements WithMultipleSheets, SkipsUnknownSheets
{
    private array $conceptos;
    private array $almacenes;
    private array $sheetImports = [];

    public function __construct(
        private int $anio,
        IAlmacenRepository $almacenRepo,
        IConceptoMaestroRepository $conceptoRepo
    ) {
        $this->almacenes = $almacenRepo->findAllOrdered()->keyBy('nombre');

        $this->conceptos = [
            'TOTAL'       => $conceptoRepo->findByName('APERTURA DE TIENDAS', 'POA')?->id,
            'OBJETIVO'    => $conceptoRepo->findByName('APERTURA DE TIENDAS LOCALIDAD OBJETIVO', 'POA')?->id,
            'ESTRATEGICA' => $conceptoRepo->findByName('APERTURA DE TIENDAS LOCALIDAD ESTRATEGICA', 'POA')?->id,
        ];
    }

    public function sheets(): array
    {
        return [];
    }

    public function onUnknownSheet($sheetName)
    {
        if ($sheetName === 'PT 4') return;

        $sheetImport = new AperturaTiendasSheetImport(
            $this->anio, $this->conceptos, $this->almacenes, $sheetName
        );
        $this->sheetImports[] = $sheetImport;
        return $sheetImport;
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
