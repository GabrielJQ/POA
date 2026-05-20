<?php

namespace App\Application\UseCases\POA;

use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\ICacheStore;
use App\Domain\Shared\ConceptMapper;
use App\Domain\Shared\PoaHelpers;
use App\Domain\Shared\CacheKeys;
use App\Domain\ValueObjects\Periodo;

class GuardarRealesPOA
{
    public function __construct(
        private IRegistroFinancieroRepository $registroRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        private ICacheStore $cache
    ) {}

    public function execute(array $data): array
    {
        $conceptoId = (int) $data['concepto_id'];
        $almacenId = (int) $data['almacen_id'];
        $anio = (int) $data['anio'];
        $valores = $data['valores'];
        $bypassWriteOnce = $data['bypass_write_once'] ?? false;

        $poaConcepto = $this->conceptoRepo->findById($conceptoId);
        if (!$poaConcepto) {
            throw new \InvalidArgumentException("Concepto POA no encontrado: {$conceptoId}");
        }

        $erConceptos = $this->conceptoRepo->pluckByCategoria('ER', 'nombre', 'id');
        $metaConceptoId = ConceptMapper::mapPoaToErConceptId($poaConcepto, $erConceptos);

        $programa = PoaHelpers::detectarPrograma($poaConcepto->nombre);

        $errors = [];
        $saved = 0;

        $esVentas = PoaHelpers::esVentas($poaConcepto->nombre);

        if ($esVentas) {
            $lpIds = $this->conceptoRepo->pluckIdsByCategoria('LINEA_PRODUCTO');
        }

        foreach ($valores as $valor) {
            $mes = (int) $valor['mes'];
            $monto = (float) $valor['monto'];

            $existing = $this->registroRepo->findByUniqueKey(
                $almacenId, $metaConceptoId, $mes, $anio, 'REAL', $programa
            );

            if (!$existing && $esVentas) {
                $lpRecord = $this->registroRepo->getByAnioYTipoDato($anio, ['REAL'], $almacenId)
                    ->whereIn('concepto_id', $lpIds->toArray())
                    ->where('mes', $mes)
                    ->first();
                if ($lpRecord) {
                    if ($programa === null || $lpRecord->programa === $programa) {
                        $existing = $lpRecord;
                    }
                }
            }

            if ($existing) {
                if ($bypassWriteOnce) {
                    $this->registroRepo->update($existing->id, ['monto' => $monto]);
                    $saved++;
                    continue;
                }
                $monthName = Periodo::NOMBRES_MESES[$mes] ?? "Mes {$mes}";
                $errors[] = "{$monthName}: ya existe un registro y no puede modificarse.";
                continue;
            }

            $this->registroRepo->create([
                'almacen_id' => $almacenId,
                'concepto_id' => $metaConceptoId,
                'mes' => $mes,
                'anio' => $anio,
                'monto' => $monto,
                'tipo_dato' => 'REAL',
                'programa' => $programa,
            ]);

            $saved++;
        }

        if ($saved > 0) {
            $this->cache->increment(CacheKeys::POA_VERSION);
        }

        return [
            'success' => count($errors) === 0,
            'saved' => $saved,
            'errors' => $errors,
        ];
    }
}
