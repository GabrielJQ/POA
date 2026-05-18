<?php

namespace App\Application\UseCases\POA;

use App\Domain\Contracts\ICacheStore;
use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Shared\CacheKeys;
use App\Imports\VentasDetalladasImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ImportarVentasDetalladas
{
    public function __construct(
        private IRegistroFinancieroRepository $registroRepo,
        private IAlmacenRepository $almacenRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        private ICacheStore $cache
    ) {}

    public function execute(UploadedFile $archivo, int $anio): array
    {
        $import = new VentasDetalladasImport($anio, $this->almacenRepo, $this->conceptoRepo);
        Excel::import($import, $archivo);

        $upsertData = $import->getUpsertData();

        if (!empty($upsertData)) {
            $chunks = array_chunk($upsertData, 500);
            foreach ($chunks as $chunk) {
                $this->registroRepo->upsertMany(
                    $chunk,
                    ['almacen_id', 'concepto_id', 'mes', 'anio', 'tipo_dato', 'programa'],
                    ['monto', 'updated_at']
                );
            }
        }

        $this->cache->increment(CacheKeys::POA_VERSION);

        return ['message' => 'Importación de ventas detalladas completada.'];
    }
}
