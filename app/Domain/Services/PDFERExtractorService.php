<?php

namespace App\Domain\Services;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PDFERExtractorService
{
    public function extract(string $pdfPath, int $anio): array
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();
        
        // Detectar Mes
        $mes = $this->detectarMes($text);
        if (!$mes) {
            throw new \Exception("No se pudo detectar el mes en el archivo PDF.");
        }

        // Detectar Almacén Ayutla
        $almacen = Almacen::where('nombre', 'ilike', '%AYUTLA%')->first();
        if (!$almacen) {
             throw new \Exception("No se encontró el almacén AYUTLA MIXES en el sistema.");
        }

        $lineas = explode("\n", $text);
        $resultados = [];

        // Definir mapeo de búsqueda
        $mapeo = [
            'TOTAL GASTOS DE DISTRIBUCION' => 'TOTAL DE GTOS DE DISTRIBUCION',
            'RESULTADO DIRECTO DE OPERACION' => 'RESULTADO DIRECTO DE OPERACIÓN'
        ];

        foreach ($mapeo as $search => $dbName) {
            foreach ($lineas as $linea) {
                if (stripos($linea, $search) !== false) {
                    $monto = $this->extraerMontoAyutla($linea);
                    if ($monto !== null) {
                        // Importante: Especificar categoria ER para evitar contaminar POA
                        $concepto = ConceptoMaestro::where('nombre', $dbName)
                            ->where('categoria', 'ER')
                            ->first();
                        
                        if ($concepto) {
                            $resultados[] = [
                                'almacen_id' => $almacen->id,
                                'concepto_id' => $concepto->id,
                                'anio' => $anio,
                                'mes' => $mes,
                                'monto' => $monto,
                                'tipo_dato' => 'REAL'
                            ];
                        }
                    }
                    // Solo tomar la primera coincidencia (la tabla principal)
                    break; 
                }
            }
        }

        if (empty($resultados)) {
            throw new \Exception("No se encontraron los conceptos requeridos en el PDF.");
        }

        // Guardar Resultados
        $count = 0;
        foreach ($resultados as $res) {
            RegistroFinanciero::updateOrCreate(
                [
                    'almacen_id' => $res['almacen_id'],
                    'concepto_id' => $res['concepto_id'],
                    'anio' => $res['anio'],
                    'mes' => $res['mes'],
                    'tipo_dato' => 'REAL'
                ],
                ['monto' => $res['monto']]
            );
            $count++;
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

    private function extraerMontoAyutla(string $linea): ?float
    {
        // El volcado de texto del PDF pone Ayutla ($) en la SEGUNDA posición numérica
        // tras quitar el nombre del concepto.
        
        // 1. Quitamos el inicio de la línea hasta el final del nombre del concepto
        $lineaSoloNumeros = preg_replace('/^.*[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,}\s+/', '', $linea);
        
        // 2. Extraer todos los números
        preg_match_all('/-?\d{1,3}(?:,\d{3})*(?:\.\d+)?/', $lineaSoloNumeros, $matches);
        
        // Según el volcado de texto REAL observado:
        // Index 0: ALMACEN CENTRAL OAXA ($)
        // Index 1: AYUTLA MIXES ($) <-- ESTO ES LO QUE DICE EL DEPURADOR
        
        if (isset($matches[0]) && count($matches[0]) >= 2) {
            $montoStr = str_replace(',', '', $matches[0][1]);
            $valorEnMiles = (float)$montoStr;
            
            return $valorEnMiles * 1000;
        }

        return null;
    }
}
