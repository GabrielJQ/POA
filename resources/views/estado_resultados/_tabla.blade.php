<table class="table table-sm table-hover text-right" style="font-size: 0.85rem; white-space: nowrap;">
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
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conceptos as $concepto)
            @php
                $conceptoId = is_array($concepto) ? ($concepto['id'] ?? 0) : ($concepto->id ?? 0);
                $nombreConcepto = is_array($concepto) ? ($concepto['nombre'] ?? 'Sin nombre') : ($concepto->nombre ?? 'Sin nombre');
                $esTitulo = is_array($concepto) ? ($concepto['es_titulo'] ?? false) : ($concepto->es_titulo ?? false);
                $esCalculado = is_array($concepto) ? ($concepto['es_calculado'] ?? false) : ($concepto->es_calculado ?? false);
                $estiloFila = $esTitulo ? 'table-secondary font-weight-bold' : '';
                
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
                <tr class="{{ $estiloFila }}">
                <td class="text-left {{ $esTitulo ? 'text-uppercase' : '' }} {{ !$esTitulo && !$esCalculado ? 'pl-4' : '' }}">
                    {{ $nombreConcepto }}
                </td>
                
                @if($esTitulo)
                    <td colspan="13"></td>
                @else
                    @for($m = 1; $m <= 12; $m++)
                        <td>{{ $meses[$m] != 0 ? number_format($meses[$m], 1) : '-' }}</td>
                    @endfor
                    <td class="font-weight-bold bg-light">{{ $totalFila != 0 ? number_format($totalFila, 1) : '-' }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
