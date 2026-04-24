@if($compromisos->isEmpty())
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-lg mr-2"></i>
        No hay compromisos POA configurados. Ejecuta el seeder: <code>php artisan db:seed --class=CompromisosPoaSeeder</code>
    </div>
@else
    <div class="table-responsive">
        <table class="table poa-table table-bordered mb-0">
            <thead>
                <tr>
                    <th rowspan="2" style="min-width: 220px;">COMPROMISO</th>
                    <th rowspan="2" style="min-width: 120px;"></th>
                    <th rowspan="2" style="min-width: 90px;">META ANUAL</th>
                    <th rowspan="2" style="min-width: 100px;">UNIDAD DE MEDIDA</th>
                    <th colspan="1">AVANCE MENSUAL</th>
                    <th rowspan="2" style="min-width: 90px;">% DE LOGRO<br>DEL MES A<br>REPORTAR</th>
                    <th rowspan="2" style="min-width: 90px;">% DE LOGRO<br>SOBRE LA<br>META ANUAL</th>
                    <th rowspan="2" style="min-width: 130px;">NOTA ACLARATORIA</th>
                </tr>
                <tr>
                    <th>{{ $meses[$mesActual] ?? 'ENERO' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compromisos as $compromiso)
                    @php
                        $fila1 = $dataPoa[$compromiso->id][$compromiso->label_fila_1] ?? null;
                        $fila2 = $dataPoa[$compromiso->id][$compromiso->label_fila_2] ?? null;

                        $mesCol = 'mes_' . str_pad($mesActual, 2, '0', STR_PAD_LEFT);
                        
                        // Valores comprometidos
                        $metaAnual1 = $fila1 ? (float)$fila1->meta_anual : 0;
                        $avanceMes1 = $fila1 ? (float)$fila1->$mesCol : 0;

                        // Valores realizados
                        $metaAnual2 = $fila2 ? (float)$fila2->meta_anual : 0;
                        $avanceMes2 = $fila2 ? (float)$fila2->$mesCol : 0;

                        // % de Logro del Mes = (Realizado mes / Comprometido mes) * 100
                        $pctMes = ($avanceMes1 != 0) ? ($avanceMes2 / $avanceMes1) * 100 : 0;

                        // % de Logro sobre Meta Anual = (Realizado acumulado / Meta anual comprometida) * 100
                        $pctAnual = ($metaAnual1 != 0) ? ($metaAnual2 / $metaAnual1) * 100 : 0;

                        // Determinar si es moneda
                        $esMoneda = in_array(strtoupper($compromiso->unidad_medida), ['PESOS']);
                    @endphp

                    {{-- FILA 1: COMPROMETIDO --}}
                    <tr class="poa-row-comprometido">
                        <td class="poa-concepto-nombre" rowspan="2">
                            {{ $compromiso->nombre }}
                        </td>
                        <td class="poa-tipo-badge">
                            <span class="badge bg-institucional-verde px-2 py-1" style="font-size: 0.65rem;">
                                {{ $compromiso->label_fila_1 }}
                            </span>
                        </td>
                        <td class="poa-monto {{ $metaAnual1 == 0 ? 'poa-monto-cero' : '' }} {{ $metaAnual1 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($metaAnual1, 2, '.', ',') }}
                            @else
                                {{ number_format($metaAnual1, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-unidad" rowspan="2">{{ $compromiso->unidad_medida }}</td>
                        <td class="poa-monto {{ $avanceMes1 == 0 ? 'poa-monto-cero' : '' }} {{ $avanceMes1 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($avanceMes1, 2, '.', ',') }}
                            @else
                                {{ number_format($avanceMes1, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-pct {{ $pctMes >= 90 ? 'poa-pct-ok' : ($pctMes >= 50 ? 'poa-pct-warn' : 'poa-pct-bad') }}" rowspan="2">
                            {{ number_format($pctMes, 0) }}%
                        </td>
                        <td class="poa-pct {{ $pctAnual >= 90 ? 'poa-pct-ok' : ($pctAnual >= 50 ? 'poa-pct-warn' : 'poa-pct-bad') }}" rowspan="2">
                            {{ number_format($pctAnual, 0) }}%
                        </td>
                        <td class="poa-nota" rowspan="2">
                            {{ $fila1->nota_aclaratoria ?? '' }}
                        </td>
                    </tr>

                    {{-- FILA 2: REALIZADO --}}
                    <tr class="poa-row-realizado">
                        <td class="poa-tipo-badge">
                            <span class="badge" style="background-color: var(--gob-oro); color: white; font-size: 0.65rem; padding: 4px 8px;">
                                {{ $compromiso->label_fila_2 }}
                            </span>
                        </td>
                        <td class="poa-monto {{ $metaAnual2 == 0 ? 'poa-monto-cero' : '' }} {{ $metaAnual2 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($metaAnual2, 2, '.', ',') }}
                            @else
                                {{ number_format($metaAnual2, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-monto {{ $avanceMes2 == 0 ? 'poa-monto-cero' : '' }} {{ $avanceMes2 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($avanceMes2, 2, '.', ',') }}
                            @else
                                {{ number_format($avanceMes2, 0, '.', ',') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2 px-2 text-muted small">
        <i class="fas fa-info-circle mr-1"></i>
        <strong>Leyenda:</strong>
        <span class="poa-pct-ok mx-1">■ ≥90%</span>
        <span class="poa-pct-warn mx-1">■ 50-89%</span>
        <span class="poa-pct-bad mx-1">■ <50%</span>
        &nbsp;|&nbsp;
        <i class="fas fa-database mr-1"></i>
        Los datos de compromisos mapeados al ER se sincronizan automáticamente.
    </div>
@endif
