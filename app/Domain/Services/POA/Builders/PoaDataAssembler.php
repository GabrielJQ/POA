<?php

namespace App\Domain\Services\POA\Builders;

use App\Domain\Shared\ConceptMapper;
use App\Domain\Shared\PoaHelpers;

class PoaDataAssembler
{
    public function __construct(
        private MetaDataBuilder $metaBuilder,
        private RealDataBuilder $realBuilder,
        private PoaNotaDecorator $notaDecorator
    ) {}

    public function assemble(
        $compromisos,
        $erConceptos,
        $metasPorConcepto,
        $realesPorConcepto,
        $ventasRecords,
        ?int $almacenId,
        array $meses,
        $notas = null
    ): array {
        $dataPoa = [];
        $ventasPorPrograma = $ventasRecords->groupBy('programa');

        foreach ($compromisos as $compromiso) {
            $label1 = $compromiso->label_fila_1 ?? 'COMPROMETIDO';
            $label2 = $compromiso->label_fila_2 ?? 'REALIZADO';

            $esPorcentaje = PoaHelpers::esPorcentaje($compromiso->unidad_medida);
            $metaConceptoId = ConceptMapper::mapPoaToErConceptId($compromiso, $erConceptos);

            $obj1 = $this->metaBuilder->build(
                $esPorcentaje, $metaConceptoId, $metasPorConcepto, $almacenId, $meses
            );
            $this->notaDecorator->decorate($obj1, $compromiso->id, $label1, $notas);

            $obj2 = $this->realBuilder->build(
                $compromiso->nombre, $esPorcentaje, $metaConceptoId, 
                $realesPorConcepto, $ventasRecords, $ventasPorPrograma, 
                $almacenId, $meses
            );
            $this->notaDecorator->decorate($obj2, $compromiso->id, $label2, $notas);

            $dataPoa[$compromiso->id][$label1] = $obj1;
            $dataPoa[$compromiso->id][$label2] = $obj2;
        }

        return $dataPoa;
    }
}
