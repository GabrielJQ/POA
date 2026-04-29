<?php

namespace App\Domain\Services;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use App\Models\UnidadOperativa;
use Smalot\PdfParser\Parser;
use Exception;

class PDFERExtractorService
{
    /**
     * Mapeo de índices de columnas numéricas en el texto extraído a nombres de almacenes.
     * Según el formato estándar detectado:
     */
    private array $indiceAlmacenes = [
        0 => 'ALMACEN CENTRAL OAXACA',
        1 => 'AYUTLA MIXES',
        2 => 'CUAJIMOLOYAS',
        3 => 'SAN JOSE EL CHILAR',
        4 => 'IXTLAN DE JUAREZ',
        5 => 'SAN PEDRO JUCHATENGO',
        6 => 'MAGDALENA OCOTLAN',
        7 => 'SAN ANDRES HIDALGO',
        8 => 'SANTIAGO TEOTITLAN',
        9 => 'TAMAZULAPAN', // Agregado por si aparece
    ];

    public function extract(string $filePath, int $anio): array
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();

        $mes = $this->detectarMes($text);
        if (!$mes) {
            throw new Exception("No se pudo detectar el mes en el archivo PDF.");
        }

        $lineas = explode("\n", $text);
        
        $mapeo = [
            'TOTAL GASTOS DE DISTRIBUCION' => 'TOTAL DE GTOS DE DISTRIBUCION',
            'RESULTADO DIRECTO DE OPERACION' => 'RESULTADO DIRECTO DE OPERACIÓN'
        ];

        $resultados = [];

        foreach ($mapeo as $search => $dbName) {
            foreach ($lineas as $linea) {
                if (stripos($linea, $search) !== false) {
                    $montos = $this->extraerMontosPorAlmacen($linea);
                    
                    if (!empty($montos)) {
                        $concepto = ConceptoMaestro::where('nombre', $dbName)
                            ->where('categoria', 'ER')
                            ->first();
                        
                        if ($concepto) {
                            foreach ($montos as $nombreAlmacen => $monto) {
                                $resultados[] = [
                                    'almacen_nombre' => $nombreAlmacen,
                                    'concepto_id' => $concepto->id,
                                    'anio' => $anio,
                                    'mes' => $mes,
                                    'monto' => $monto,
                                    'tipo_dato' => 'REAL'
                                ];
                            }
                        }
                    }
                    break; 
                }
            }
        }

        if (empty($resultados)) {
            throw new Exception("No se encontraron los conceptos requeridos en el PDF.");
        }

        // Guardar Resultados
        $count = 0;
        foreach ($resultados as $res) {
            // Solo procesar si el almacén existe en la lista oficial
            $almacen = Almacen::where('nombre', 'ilike', $res['almacen_nombre'])->first();

            if ($almacen) {
                RegistroFinanciero::updateOrCreate(
                    [
                        'almacen_id' => $almacen->id,
                        'concepto_id' => $res['concepto_id'],
                        'anio' => $res['anio'],
                        'mes' => $res['mes'],
                        'tipo_dato' => 'REAL'
                    ],
                    ['monto' => $res['monto']]
                );
                $count++;
            }
        }

        return [
            'success' => true,
            'count' => $count,
            'mes' => $mes,
            'anio' => $anio
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

    private function extraerMontosPorAlmacen(string $linea): array
    {
        $resultados = [];
        
        // 1. Limpiar la línea de texto del nombre del concepto inicial
        $lineaSoloNumeros = preg_replace('/^.*[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,}\s+/', '', $linea);
        
        // 2. Extraer todos los números
        preg_match_all('/-?\d{1,3}(?:,\d{3})*(?:\.\d+)?/', $lineaSoloNumeros, $matches);
        
        if (isset($matches[0])) {
            foreach ($matches[0] as $index => $montoStr) {
                if (isset($this->indiceAlmacenes[$index])) {
                    $nombreAlmacen = $this->indiceAlmacenes[$index];
                    $montoLimpio = str_replace(',', '', $montoStr);
                    $valor = (float)$montoLimpio;
                    
                    // Solo guardar si es un valor significativo (para evitar ceros de relleno si aplica)
                    $resultados[$nombreAlmacen] = $valor * 1000;
                }
            }
        }

        return $resultados;
    }
}
