<?php

namespace App\Imports;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class MermasQuebrantosImport implements WithMultipleSheets, SkipsUnknownSheets
{
    private Collection $almacenes;
    private ?int $conceptoId;
    private array $porcentajes;
    private array $sheetImports = [];

    public function __construct(
        private int $anio,
        IAlmacenRepository $almacenRepo,
        IConceptoMaestroRepository $conceptoRepo
    ) {
        $this->porcentajes = config('mermas.lineas', []);
        $this->almacenes = $almacenRepo->findAllOrdered()->keyBy('nombre');

        $concepto = $conceptoRepo->findByName('MERMAS, QUEBRANTOS Y MAL ESTADO', 'POA');
        $this->conceptoId = $concepto?->id;
    }

    public function sheets(): array
    {
        return [];
    }

    public function onUnknownSheet($sheetName)
    {
        $sheetImport = new MermasQuebrantosSheetImport(
            $this->anio, $this->conceptoId, $this->porcentajes, $this->almacenes, $sheetName
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
