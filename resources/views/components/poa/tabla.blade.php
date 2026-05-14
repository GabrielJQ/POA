@props([
    'compromisos' => collect(),
    'dataPoa' => [],
    'config' => [],
    'labelPeriodo' => 'ENERO',
    'anioSeleccionado' => null,
    'almacenSeleccionado' => null,
    'mostrarConsolidado' => true,
])

@php
    $mesesConfig = $config['meses'] ?? [1];
    $totalMeses = count($mesesConfig);
    $primerMes = $mesesConfig[0] ?? 1;

    if ($totalMeses === 1) {
        $notaMes = $primerMes;
    } elseif ($totalMeses === 3) {
        $notaMes = 100 + (int) ceil($primerMes / 3);
    } else {
        $notaMes = 0;
    }

    $notaAlmacen = $mostrarConsolidado ? '' : $almacenSeleccionado;
@endphp

@if($compromisos->isEmpty())
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-lg mr-2"></i>
        No hay compromisos POA configurados. Ejecuta el seeder: <code>php artisan db:seed --class=CompromisosPoaSeeder</code>
    </div>
@else
    <table class="table poa-table table-bordered mb-0">
            <thead>
                <tr>
                    <th style="min-width: 220px;">COMPROMISO</th>
                    <th style="min-width: 120px;"></th>
                    <th style="min-width: 90px;">META ANUAL</th>
                    <th style="min-width: 100px;">UNIDAD DE MEDIDA</th>
                    <th style="min-width: 130px;">AVANCE {{ $labelPeriodo ?? 'PERIODO' }}</th>
                    <th style="min-width: 90px;">% LOGRO PERIODO</th>
                    <th style="min-width: 90px;">% LOGRO ANUAL</th>
                    <th style="min-width: 130px;">NOTA ACLARATORIA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compromisos as $compromiso)
                    @php
                        $fila1 = $dataPoa[$compromiso->id][$compromiso->label_fila_1] ?? null;
                        $fila2 = $dataPoa[$compromiso->id][$compromiso->label_fila_2] ?? null;

                        $mesesConfig = $config['meses'] ?? [1];
                        $primerMes = $mesesConfig[0] ?? 1;
                        $ultimoMes = $mesesConfig[count($mesesConfig) - 1] ?? $primerMes;
                        $mesCol = 'mes_' . str_pad($primerMes, 2, '0', STR_PAD_LEFT);
                        
                        $metaAnual1 = $fila1 ? (float)$fila1->meta_anual : 0;
                        $avancePeriodo1 = 0;
                        foreach ($mesesConfig as $m) {
                            $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                            $avancePeriodo1 += $fila1 ? (float)($fila1->$col ?? 0) : 0;
                        }

                        $metaAnual2 = $fila2 ? (float)$fila2->meta_anual : 0;
                        $avancePeriodo2 = 0;
                        foreach ($mesesConfig as $m) {
                            $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                            $avancePeriodo2 += $fila2 ? (float)($fila2->$col ?? 0) : 0;
                        }

                        $esPorcentaje = stripos($compromiso->unidad_medida ?? '', 'PORCENTAJE') !== false;
                        if ($esPorcentaje) {
                            $avancePeriodo1 = 100;
                        }

                        $pctPeriodo = ($avancePeriodo1 != 0) ? ($avancePeriodo2 / $avancePeriodo1) * 100 : 0;
                        $pctAnual = ($metaAnual1 != 0) ? ($metaAnual2 / $metaAnual1) * 100 : 0;
                        $esMoneda = in_array(strtoupper($compromiso->unidad_medida), ['PESOS']);
                    @endphp

                    <tr class="poa-row-comprometido poa-row-group">
                        <td class="poa-concepto-nombre" rowspan="2">
                            {{ $compromiso->nombre }}
                        </td>
                        <td class="poa-tipo-badge">
                            <span class="badge bg-institucional-verde px-3 py-1" style="font-size: 0.7rem; border-radius: 6px;">
                                {{ $compromiso->label_fila_1 }}
                            </span>
                        </td>
                        <td class="poa-monto {{ $metaAnual1 == 0 ? 'poa-monto-cero' : '' }} {{ $metaAnual1 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($metaAnual1, 2, '.', ',') }}
                            @elseif($esPorcentaje)
                                {{ number_format($metaAnual1, 2, '.', ',') }}
                            @else
                                {{ number_format($metaAnual1, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-unidad" rowspan="2">{{ $compromiso->unidad_medida }}</td>
                        <td class="poa-monto {{ $avancePeriodo1 == 0 ? 'poa-monto-cero' : '' }} {{ $avancePeriodo1 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($avancePeriodo1, 2, '.', ',') }}
                            @elseif($esPorcentaje)
                                {{ number_format($avancePeriodo1, 2, '.', ',') }}
                            @else
                                {{ number_format($avancePeriodo1, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-pct {{ $pctPeriodo >= 90 ? 'poa-pct-ok' : ($pctPeriodo >= 50 ? 'poa-pct-warn' : 'poa-pct-bad') }}" rowspan="2">
                            {{ number_format($pctPeriodo, $esPorcentaje ? 2 : 0) }}%
                        </td>
                        <td class="poa-pct {{ $pctAnual >= 90 ? 'poa-pct-ok' : ($pctAnual >= 50 ? 'poa-pct-warn' : 'poa-pct-bad') }}" rowspan="2">
                            {{ number_format($pctAnual, $esPorcentaje ? 2 : 0) }}%
                        </td>
                        <td class="poa-nota" rowspan="2">
                            <textarea class="form-control form-control-sm nota-textarea"
                                data-concepto-id="{{ $compromiso->id }}"
                                data-label="{{ $compromiso->label_fila_1 ?? 'COMPROMETIDO' }}"
                                data-anio="{{ $anioSeleccionado ?? date('Y') }}"
                                data-mes="{{ $notaMes }}"
                                data-almacen-id="{{ $notaAlmacen }}"
                                placeholder="Escribe una nota..."
                                rows="2">{{ $fila1->nota_aclaratoria ?? '' }}</textarea>
                        </td>
                    </tr>

                    <tr class="poa-row-realizado poa-row-group">
                        <td class="poa-tipo-badge">
                            <span class="badge bg-institucional-oro px-3 py-1" style="color: white; font-size: 0.7rem; border-radius: 6px;">
                                {{ $compromiso->label_fila_2 }}
                            </span>
                        </td>
                        <td class="poa-monto {{ $metaAnual2 == 0 ? 'poa-monto-cero' : '' }} {{ $metaAnual2 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($metaAnual2, 2, '.', ',') }}
                            @elseif($esPorcentaje)
                                {{ number_format($metaAnual2, 2, '.', ',') }}
                            @else
                                {{ number_format($metaAnual2, 0, '.', ',') }}
                            @endif
                        </td>
                        <td class="poa-monto {{ $avancePeriodo2 == 0 ? 'poa-monto-cero' : '' }} {{ $avancePeriodo2 < 0 ? 'poa-monto-negativo' : '' }}">
                            @if($esMoneda)
                                {{ number_format($avancePeriodo2, 2, '.', ',') }}
                            @elseif($esPorcentaje)
                                {{ number_format($avancePeriodo2, 2, '.', ',') }}
                            @else
                                {{ number_format($avancePeriodo2, 0, '.', ',') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="poa-leyenda-footer">
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