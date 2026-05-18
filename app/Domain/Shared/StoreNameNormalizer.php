<?php

namespace App\Domain\Shared;

class StoreNameNormalizer
{
    private static array $map = [
        // Surtimiento & Apertura variations
        'AYUTLA MIXE'               => 'AYUTLA MIXES',
        'SN ANDRES HIDALGO.'        => 'SAN ANDRES HIDALGO',
        'EL CHILAR'                 => 'SAN JOSE EL CHILAR',
        'JUCHATENGO'                => 'SAN PEDRO JUCHATENGO',
        'SANTA MA. LACHIXIO'        => 'LACHIXIO',
        'SANTA MARIA LACHIXIO'      => 'LACHIXIO',
        'TAMAZULAPAM'               => 'TAMAZULAPAN',
        'TEOTITLAN DE F.M.'         => 'SANTIAGO TEOTITLAN',
        'TEOTITLAN DE FLORES MAGON' => 'SANTIAGO TEOTITLAN',
        'SANTO TOMAS TAMAZULAPAN'   => 'TAMAZULAPAN',
        
        // Mermas (PT prefixes)
        'PT AYUTLA'                 => 'AYUTLA MIXES',
        'PT CHILAR'                 => 'SAN JOSE EL CHILAR',
        'PT CUAJIMOLOYAS'           => 'CUAJIMOLOYAS',
        'PT IXTLAN'                 => 'IXTLAN DE JUAREZ',
        'PT JUCHATENGO'             => 'SAN PEDRO JUCHATENGO',
        'PT LACHIXIO'               => 'LACHIXIO',
        'PT MATATLAN'               => 'SANTIAGO MATATLAN',
        'PT MAGDALENA OCOTLAN'      => 'MAGDALENA OCOTLAN',
        'PT SAN ANDRES'             => 'SAN ANDRES HIDALGO',
        'PT TAMAZULAPAN'            => 'TAMAZULAPAN',
        'PT TEOTITLAN'              => 'SANTIAGO TEOTITLAN',
        'PT VALLES'                 => 'VALLES CENTRALES',
    ];

    public static function normalize(string $rawName): string
    {
        $rawName = mb_strtoupper(trim($rawName));
        
        // Remove known trailing suffixes in ER/Excel
        $rawName = preg_replace('/\s+PROFORMA\s*$/i', '', $rawName);
        $rawName = preg_replace('/\s+CONSOLIDADO\s*$/i', '', $rawName);
        $rawName = preg_replace('/\s*\([^)]*\)\s*/', '', $rawName);

        // Common typos
        $rawName = str_replace('MAGADALENA', 'MAGDALENA', $rawName);
        $rawName = str_replace('TAMAZULAPAM', 'TAMAZULAPAN', $rawName);
        $rawName = str_replace('TEOTITLAN DE FLORES MAGON', 'SANTIAGO TEOTITLAN', $rawName);

        if ($rawName === 'VALLES') {
            return 'VALLES CENTRALES';
        }

        if (str_contains($rawName, 'EL CHILAR') && !str_contains($rawName, 'SAN JOSE')) {
            $rawName = str_replace('EL CHILAR', 'SAN JOSE EL CHILAR', $rawName);
        }
        
        if (str_contains($rawName, 'ALMACEN DE VALLES CENTRALES') || str_contains($rawName, 'UNIDAD OPERATIVA VALLES CENTRALES')) {
            return 'VALLES CENTRALES';
        }

        // 1. Direct map lookup
        if (isset(self::$map[$rawName])) {
            return self::$map[$rawName];
        }

        // 2. Try removing 'PT ' prefix if it exists and wasn't mapped
        $limpio = str_replace('PT ', '', $rawName);
        if (isset(self::$map[$limpio])) {
            return self::$map[$limpio];
        }

        // 3. Fallback to the cleaned name (assuming it matches the DB)
        return $limpio !== '' ? $limpio : $rawName;
    }
}
