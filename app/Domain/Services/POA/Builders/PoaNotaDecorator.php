<?php

namespace App\Domain\Services\POA\Builders;

class PoaNotaDecorator
{
    public function decorate(\stdClass $obj, int $conceptoId, string $label, $notas): void
    {
        $key = $conceptoId . '|' . $label;
        $obj->nota_aclaratoria = $notas ? ($notas->get($key)?->nota_aclaratoria ?? '') : '';
    }
}
