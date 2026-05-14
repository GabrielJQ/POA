<div id="contenedor-tabla-er">
    <table class="table table-sm table-hover text-right table-er" style="font-size: 0.85rem; white-space: nowrap;">
        <thead class="text-center">
            <tr>
                <th class="text-left" style="min-width: 250px;">CONCEPTO</th>
                <th>ENERO</th>
                <th>FEBRERO</th>
                <th>MARZO</th>
                <th>ABRIL</th>
                <th>MAYO</th>
                <th>JUNIO</th>
                <th>JULIO</th>
                <th>AGOSTO</th>
                <th>SEPTIEMBRE</th>
                <th>OCTUBRE</th>
                <th>NOVIEMBRE</th>
                <th>DICIEMBRE</th>
                <th class="bg-dark">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos as $concepto)
                @php
                    $conceptoId = is_array($concepto) ? ($concepto['id'] ?? 0) : ($concepto->id ?? 0);
                    $nombreConcepto = is_array($concepto) ? ($concepto['nombre'] ?? 'Sin nombre') : ($concepto->nombre ?? 'Sin nombre');
                    $esTitulo = is_array($concepto) ? ($concepto['es_titulo'] ?? false) : ($concepto->es_titulo ?? false);
                    $esCalculado = is_array($concepto) ? ($concepto['es_calculado'] ?? false) : ($concepto->es_calculado ?? false);
                    
                    $rowClass = '';
                    if ($esTitulo) $rowClass = 'er-row-title';
                    elseif ($esCalculado) $rowClass = 'er-row-calculated';
                    
                    $conceptoData = $matriz[$conceptoId] ?? null;
                    if (is_object($conceptoData) && isset($conceptoData->montos)) {
                        $meses = $conceptoData->montos;
                    } elseif (is_array($conceptoData)) {
                        $meses = $conceptoData;
                    } else {
                        $meses = array_fill(1, 12, 0);
                    }
                    $totalFila = array_sum($meses);
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-left concepto-col {{ $esTitulo ? 'text-uppercase' : '' }} {{ !$esTitulo && !$esCalculado ? 'pl-4' : '' }}">
                        {{ $nombreConcepto }}
                    </td>
                    
                    @if($esTitulo)
                        <td colspan="13"></td>
                    @else
                        @for($m = 1; $m <= 12; $m++)
                            @php $val = $meses[$m] ?? 0; @endphp
                            <td class="er-monto {{ $val == 0 ? 'er-monto-cero' : '' }} {{ $val < 0 ? 'er-monto-negativo' : '' }}">
                                @if($val != 0)
                                    {{ number_format($val, 1) }}
                                @else
                                    <span class="text-muted-dash">-</span>
                                @endif
                            </td>
                        @endfor
                        <td class="font-weight-bold total-col er-monto {{ $totalFila == 0 ? 'er-monto-cero' : '' }} {{ $totalFila < 0 ? 'er-monto-negativo' : '' }}">
                            {{ $totalFila != 0 ? number_format($totalFila, 1) : '-' }}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
