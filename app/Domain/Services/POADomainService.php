<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Contracts\Repositories\IPoaNotaRepository;
use App\Domain\Contracts\ICacheStore;

use App\Domain\Contracts\IPOADomainService;
use App\Domain\Shared\CacheKeys;
use App\Domain\Services\POA\Builders\PoaDataAssembler;

class POADomainService implements IPOADomainService
{
    public function __construct(
        private PoaDataAssembler $assembler,
        private IConceptoMaestroRepository $conceptoRepo,
        private IRegistroFinancieroRepository $registroRepo,
        private IPoaNotaRepository $notaRepo,
        private ICacheStore $cache
    ) {}

    public function obtenerDatosPOA(FiltrosPOA $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();
        $meses = $filtros->getPeriodo()->getMeses();
        $periodoTipo = $filtros->getPeriodo()->getTipo();
        $notaMes = $filtros->getPeriodo()->getNotaMes();

        $version = $this->cache->get(CacheKeys::POA_VERSION, 0);
        $cacheKey = CacheKeys::poaData($anio, $almacenId, $periodoTipo, $notaMes, $version);

        return $this->cache->remember($cacheKey, 300, function () use ($filtros, $anio, $almacenId, $meses, $notaMes) {
            $compromisos = $this->conceptoRepo->getByCategoria('POA');
            $erConceptos = $this->conceptoRepo->pluckByCategoria('ER', 'nombre', 'id');

            $records = $this->registroRepo->getByAnioYTipoDato($anio, ['META', 'REAL'], $almacenId);

            $metasPorConcepto = $records->where('tipo_dato', 'META')->groupBy('concepto_id');
            $realesPorConcepto = $records->where('tipo_dato', 'REAL')->groupBy('concepto_id');

            $lpIds = $this->conceptoRepo->pluckIdsByCategoria('LINEA_PRODUCTO');

            $ventasRecords = $records->where('tipo_dato', 'REAL')
                ->filter(fn($r) => $lpIds->contains($r->concepto_id));

            $notas = $this->notaRepo->getByAnioMesYAlmacen($anio, $notaMes, $almacenId)
                ->keyBy(fn($n) => $n->concepto_id . '|' . $n->label);

            $dataPoa = $this->assembler->assemble(
                $compromisos, $erConceptos, $metasPorConcepto, $realesPorConcepto,
                $ventasRecords, $almacenId, $meses, $notas
            );

            return [
                'compromisos' => $compromisos,
                'dataPoa' => $dataPoa,
            ];
        });
    }

    public function sincronizarDesdeER(int $almacenId, int $anio): int
    {
        return 0;
    }
}
