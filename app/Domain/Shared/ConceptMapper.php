<?php

namespace App\Domain\Shared;

use Illuminate\Support\Collection;

class ConceptMapper
{
    /**
     * Map a POA concept to its corresponding ER concept ID
     */
    public static function mapPoaToErConceptId(object $compromiso, Collection $erConceptos): int
    {
        $metaConceptoId = $compromiso->id;
        $conceptoNombre = trim($compromiso->concepto_er_nombre ?? '');

        if ($conceptoNombre !== '') {
            $conceptoER = $erConceptos->get($conceptoNombre)
                ?? $erConceptos->first(fn($id, $name) => 
                    stripos($name, $conceptoNombre) !== false || 
                    stripos($conceptoNombre, $name) !== false
                );
            
            if ($conceptoER) {
                $metaConceptoId = $conceptoER;
            }
        }

        return $metaConceptoId;
    }
}
