<?php

namespace App\Application\UseCases\ER;

use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\CacheKeys;
use App\Imports\ERImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportarER
{
    private ICacheStore $cache;

    public function __construct(
        ICacheStore $cache
    ) {
        $this->cache = $cache;
    }

    public function execute(int $anio, $archivo): array
    {
        Excel::import(new ERImport($anio), $archivo);

        $this->cache->increment(CacheKeys::POA_VERSION);

        return [
            'message' => "Estado de Resultados importado para {$anio}. Los datos del POA se actualizan automáticamente.",
            'success' => true,
        ];
    }
}
