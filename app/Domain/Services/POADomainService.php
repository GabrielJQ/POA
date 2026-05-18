<?php

namespace App\Domain\Services;

use App\Domain\ValueObjects\FiltrosPOA;
use App\Models\ConceptoMaestro;
use App\Models\PoaNota;
use App\Models\RegistroFinanciero;
use Illuminate\Support\Facades\Cache;

use App\Domain\Contracts\IPOADomainService;
use App\Domain\Shared\CacheKeys;
use App\Domain\Services\POA\Builders\PoaDataAssembler;

class POADomainService implements IPOADomainService
{
    public function __construct(
        private PoaDataAssembler $assembler
    ) {}

    public function obtenerDatosPOA(FiltrosPOA $filtros): array
    {
        $anio = $filtros->getAnio();
        $almacenId = $filtros->getAlmacenId();
        $meses = $filtros->getPeriodo()->getMeses();
        $periodoTipo = $filtros->getPeriodo()->getTipo();
        $notaMes = $filtros->getPeriodo()->getNotaMes();

        $version = Cache::get(CacheKeys::POA_VERSION, 0);
        $cacheKey = CacheKeys::poaData($anio, $almacenId, $periodoTipo, $notaMes, $version);

        return Cache::remember($cacheKey, 300, function () use ($filtros, $anio, $almacenId, $meses, $notaMes) {
            $compromisos = Cache::remember(CacheKeys::CONCEPTOS_POA, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'POA')->orderBy('orden')->get()
            );

            $erConceptos = Cache::remember(CacheKeys::CONCEPTOS_ER_PLUCK, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'ER')->pluck('id', 'nombre')
            );

            $records = RegistroFinanciero::where('anio', $anio)
                ->whereIn('tipo_dato', ['META', 'REAL']);

            if ($almacenId) {
                $records = $records->where('almacen_id', $almacenId);
            }

            $records = $records->get();

            $metasPorConcepto = $records->where('tipo_dato', 'META')->groupBy('concepto_id');
            $realesPorConcepto = $records->where('tipo_dato', 'REAL')->groupBy('concepto_id');

            $lpIds = Cache::remember(CacheKeys::CONCEPTOS_LP_IDS, 86400, fn() =>
                ConceptoMaestro::where('categoria', 'LINEA_PRODUCTO')->pluck('id')
            );

            $ventasRecords = $records->where('tipo_dato', 'REAL')
                ->filter(fn($r) => $lpIds->contains($r->concepto_id));

            $notas = PoaNota::where('anio', $anio)
                ->where('mes', $notaMes)
                ->where(function ($q) use ($almacenId) {
                    if ($almacenId === null) {
                        $q->whereNull('almacen_id');
                    } else {
                        $q->where('almacen_id', $almacenId);
                    }
                })
                ->get()
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
