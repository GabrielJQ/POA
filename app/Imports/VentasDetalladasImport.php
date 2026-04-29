<?php

namespace App\Imports;

use App\Models\Almacen;
use App\Models\ConceptoMaestro;
use App\Models\RegistroFinanciero;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Crypt;
use Exception;

class VentasDetalladasImport implements ToCollection, WithCalculatedFormulas
{
    private string $programa;

    public function __construct(string $programa = 'PAR')
    {
        $this->programa = $programa;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new Exception("El archivo está vacío.");
        }

        $almacen = $this->buscarAlmacen($rows);
        
        if (!$almacen) {
            throw new Exception("No se encontró el almacén.");
        }

        $anio = (int) date('Y');
        
        // Formato Ventas Detalladas: Enero en columna D (índice 3)
        // Se saltan las columnas de "TRIMESTRE" (6, 10, 14, 18)
        $meses = [
            1 => 3,  // Enero
            2 => 4,  // Febrero
            3 => 5,  // Marzo
            4 => 7,  // Abril
            5 => 8,  // Mayo
            6 => 9,  // Junio
            7 => 11, // Julio
            8 => 12, // Agosto
            9 => 13, // Septiembre
            10 => 15, // Octubre
            11 => 16, // Noviembre
            12 => 17  // Diciembre
        ];

        $upsertData = [];
        $now = now();

        for ($i = 9; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            $lineaNumero = isset($row[1]) ? trim((string)$row[1]) : '';
            if (empty($lineaNumero)) continue;

            $lineaNumero = (int) preg_replace('/[^\d]/', '', $lineaNumero);
            if ($lineaNumero === 0) continue;

            $lineaNombre = isset($row[0]) ? trim((string)$row[0]) : '';
            if (empty($lineaNombre)) continue;

            // Buscar línea de producto existente por número o nombre
            $linea = ConceptoMaestro::where('categoria', 'LINEA_PRODUCTO')
                ->where(function($q) use ($lineaNumero, $lineaNombre) {
                    $q->where('numero', $lineaNumero)
                      ->orWhere('nombre', $lineaNombre)
                      ->orWhere('nombre', 'ilike', $lineaNombre);
                })
                ->first();
            
            if (!$linea) {
                // Si no existe, crear nueva línea
                $linea = ConceptoMaestro::create([
                    'nombre' => $lineaNombre,
                    'categoria' => 'LINEA_PRODUCTO',
                    'numero' => $lineaNumero,
                    'orden' => 0,
                ]);
            }

            foreach ($meses as $mes => $colIndex) {
                $montoRaw = $row[$colIndex] ?? '';
                $montoStr = (string)$montoRaw;
                $montoLimpio = preg_replace('/[^\d.-]/', '', $montoStr);

                if ($montoLimpio && is_numeric($montoLimpio)) {
                    $monto = (float) $montoLimpio;
                    if ($monto > 0) {
                        $upsertData[] = [
                            'almacen_id' => $almacen->id,
                            'concepto_id' => $linea->id,
                            'mes' => $mes,
                            'anio' => $anio,
                            'monto' => $monto,
                            'tipo_dato' => 'REAL',
                            'programa' => $this->programa,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }
        }

        if (empty($upsertData)) {
            throw new Exception("No se encontró ningún monto válido.");
        }

        foreach (array_chunk($upsertData, 500) as $chunk) {
            foreach ($chunk as &$data) {
                $data['monto'] = Crypt::encryptString((string)$data['monto']);
            }
            RegistroFinanciero::upsert($chunk, 
                ['almacen_id', 'concepto_id', 'mes', 'anio', 'tipo_dato', 'programa'], 
                ['monto', 'updated_at']
            );
        }
    }

    protected function buscarAlmacen(Collection $rows): ?Almacen
    {
        $todosAlmacenes = Almacen::all();
        
        foreach ($rows as $row) {
            if (!($row instanceof Collection)) $row = collect($row);
            
            foreach ($row as $celda) {
                $celdaStr = trim((string)$celda);
                if (empty($celdaStr) || strlen($celdaStr) < 3) continue;
                if (str_starts_with($celdaStr, '=')) continue;
                
                $palabrasIgnorar = ['PRESUPUESTO', 'VENTAS', 'PROGRAMA', 'ALMACEN', 'TIENDA', 'SUCURSAL', 'REGISTRO', 'LINEA', 'NUMERO', 'IMPORTE', 'TOTAL', 'RURAL'];
                $esIgnorable = false;
                foreach ($palabrasIgnorar as $palabra) {
                    if (stripos($celdaStr, $palabra) !== false) { $esIgnorable = true; break; }
                }
                if ($esIgnorable) continue;
                
                foreach ($todosAlmacenes as $almacen) {
                    $nombreNorm = strtoupper(trim(preg_replace('/[^\w\s]/u', '', $almacen->nombre)));
                    $celdaNorm = strtoupper(trim(preg_replace('/[^\w\s]/u', '', $celdaStr)));
                    if ($celdaNorm === $nombreNorm || str_contains($celdaNorm, $nombreNorm) || str_contains($nombreNorm, $celdaNorm)) {
                        return $almacen;
                    }
                }
            }
        }
        return null;
    }
}
