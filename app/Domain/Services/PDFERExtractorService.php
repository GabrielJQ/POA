<?php

namespace App\Domain\Services;

use App\Domain\Contracts\Repositories\IAlmacenRepository;
use App\Domain\Contracts\Repositories\IConceptoMaestroRepository;
use App\Domain\Contracts\Repositories\IRegistroFinancieroRepository;
use Smalot\PdfParser\Parser;
use Exception;

use App\Domain\Contracts\IPDFERExtractorService;

class PDFERExtractorService implements IPDFERExtractorService
{
    public function __construct(
        private IAlmacenRepository $almacenRepo,
        private IConceptoMaestroRepository $conceptoRepo,
        private IRegistroFinancieroRepository $registroRepo
    ) {}

    private array $bloques = [
        0 => [
            0 => 'ALMACEN CENTRAL OAXACA',
            1 => 'AYUTLA MIXES',
            2 => 'CUAJIMOLOYAS',
            3 => 'IXTLAN DE JUAREZ',
            4 => 'MAGDALENA OCOTLAN',
            5 => 'SAN ANDRES HIDALGO',
            6 => 'SAN JOSE EL CHILAR',
            7 => 'SAN PEDRO JUCHATENGO',
            8 => 'LACHIXIO',
        ],
        1 => [
            1 => 'TAMAZULAPAN',
            2 => 'SANTIAGO TEOTITLAN',
            3 => 'VALLES CENTRALES',
            8 => 'SANTIAGO MATATLAN',
        ],
    ];

    private array $mapeoConceptos = [
        'TOTAL GASTOS DE DISTRIBUCION' => 'TOTAL DE GTOS DE DISTRIBUCION',
        'RESULTADO DIRECTO DE OPERACION' => 'RESULTADO DIRECTO DE OPERACIÓN',
    ];

    private string $regexNumero = '/-?\d{1,3}(?:,\d{3})*(?:\.\d{2})?/';

    public function extract(string $filePath, int $anio): array
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        $texto = $pdf->getText();
        $lineas = explode("\n", $texto);

        $mes = $this->detectarMes($texto);
        if (!$mes) {
            throw new Exception("No se pudo detectar el mes en el archivo PDF.");
        }

        $count = 0;
        $conceptosProcesados = [];

        foreach ($this->mapeoConceptos as $textoBuscar => $nombreDB) {
            $concepto = $this->conceptoRepo->findByName($nombreDB, 'ER');

            if (!$concepto) {
                throw new Exception("Concepto no encontrado en BD: $nombreDB");
            }

            $lineasEncontradas = [];
            foreach ($lineas as $linea) {
                if (stripos(trim($linea), $textoBuscar) !== false) {
                    $lineasEncontradas[] = trim($linea);
                }
            }

            if (empty($lineasEncontradas)) {
                throw new Exception("Línea no encontrada en PDF: $textoBuscar");
            }

            foreach ($lineasEncontradas as $orden => $linea) {
                if (!isset($this->bloques[$orden])) continue;

                $cleaned = preg_replace(
                    '/^.*?[\d]*[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{5,}\s+/',
                    '',
                    $linea
                );
                preg_match_all($this->regexNumero, $cleaned, $matches);
                $numeros = $matches[0] ?? [];

                foreach ($this->bloques[$orden] as $idx => $nombreAlmacen) {
                    if (!isset($numeros[$idx])) continue;

                    $monto = (float) str_replace(',', '', $numeros[$idx]) * 1000;
                    if ($monto == 0) continue;

                    $nombreAlmacenNorm = \App\Domain\Shared\StoreNameNormalizer::normalize($nombreAlmacen);
                    $almacen = $this->almacenRepo->findByName($nombreAlmacenNorm);
                    if (!$almacen) continue;

                    $this->registroRepo->updateOrCreate(
                        [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $concepto->id,
                            'anio' => $anio,
                            'mes' => $mes,
                            'tipo_dato' => 'REAL',
                            'programa' => null,
                        ],
                        ['monto' => (float) $monto]
                    );
                    $count++;
                }
            }

            $conceptosProcesados[] = $nombreDB;
        }

        if ($count === 0) {
            throw new Exception("No se pudo extraer ningún registro del PDF. Verifica el formato.");
        }

        return [
            'success' => true,
            'count' => $count,
            'mes' => $mes,
            'anio' => $anio,
            'conceptos' => $conceptosProcesados,
        ];
    }

    private function detectarMes(string $text): ?int
    {
        $meses = [
            'ENERO' => 1, 'FEBRERO' => 2, 'MARZO' => 3, 'ABRIL' => 4,
            'MAYO' => 5, 'JUNIO' => 6, 'JULIO' => 7, 'AGOSTO' => 8,
            'SEPTIEMBRE' => 9, 'OCTUBRE' => 10, 'NOVIEMBRE' => 11, 'DICIEMBRE' => 12
        ];
        foreach ($meses as $nombre => $num) {
            if (stripos($text, $nombre) !== false) {
                return $num;
            }
        }
        return null;
    }
}
