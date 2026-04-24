<div class="table-responsive">
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
                    $esTitulo = $concepto->tipo === 0;
                    $esCalculado = $concepto->es_calculado;
                    $estiloFila = $esTitulo ? 'font-weight-bold bg-light text-center' : ($esCalculado ? 'font-weight-bold bg-light' : '');
                    
                    $meses = $matriz[$concepto->id] ?? array_fill(1, 12, 0);
                    $totalFila = array_sum($meses);
                @endphp
                <tr class="{{ $estiloFila }}">
                    <td class="text-left {{ $esTitulo ? 'text-uppercase' : '' }} {{ !$esTitulo && !$esCalculado ? 'pl-4' : '' }}">
                        {{ $concepto->nombre }}
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
</div>
