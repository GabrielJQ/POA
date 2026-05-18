<?php

namespace App\Application\UseCases\POA;

use App\Domain\Contracts\ICacheStore;
use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Shared\CacheKeys;
use App\Imports\SurtimientoTiendasImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ImportarSurtimiento
{
    public function __construct(
        private IRegistroFinancieroRepository $registroRepo,
        private IAlmacenRepository $almacenRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        private ICacheStore $cache
    ) {}

    public function execute(UploadedFile $archivo, int $anio): array
    {
        $import = new SurtimientoTiendasImport($anio, $this->almacenRepo, $this->conceptoRepo);
        Excel::import($import, $archivo);

        $upsertData = $import->getUpsertData();

        if (!empty($upsertData)) {
            $chunks = array_chunk($upsertData, 1000);
            foreach ($chunks as $chunk) {
                $this->registroRepo->upsertMany(
                    $chunk,
                    ['almacen_id', 'concepto_id', 'anio', 'mes', 'tipo_dato', 'programa'],
                    ['monto']
                );
            }
        }

        $this->cache->increment(CacheKeys::POA_VERSION);

        return ['message' => 'Importación de surtimiento completada.'];
    }
}
