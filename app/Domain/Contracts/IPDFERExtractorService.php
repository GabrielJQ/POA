<?php

namespace App\Domain\Contracts;

interface IPDFERExtractorService
{
    public function extract(string $filePath, int $anio): array;
}
