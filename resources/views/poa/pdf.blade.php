<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page {
        size: 17in 11in;
        margin: 0.5in 0.5in 0.3in 0.5in;
    }
    * { box-sizing: border-box; }
    body {
        font-family: Arial, sans-serif;
        font-size: 8pt;
        margin: 0;
        padding: 0;
        width: 100%;
    }
    .header {
        text-align: center;
        font-weight: bold;
        font-size: 10pt;
        margin-bottom: 4px;
    }
    .header-line { margin: 1px 0; }
    .store-info {
        font-size: 8pt;
        margin-bottom: 6px;
    }
    .store-info td { padding: 1px 4px; vertical-align: top; }
    .store-info .label { font-weight: bold; white-space: nowrap; }
    table.data {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
        font-size: 6.5pt;
        page-break-after: auto;
    }
    table.data th, table.data td {
        border: 1px solid #000;
        padding: 1px 3px;
        vertical-align: middle;
        text-align: center;
    }
    table.data th {
        background: #e6e6e6;
        font-weight: bold;
        font-size: 6pt;
    }
    table.data .left { text-align: left; }
    table.data .right { text-align: right; }
    table.data .concept-name {
        text-align: left;
        font-weight: bold;
        padding-left: 4px;
        min-width: 140px;
    }
    table.data .monto { text-align: center; font-variant-numeric: tabular-nums; }
    table.data .pct-ok { color: #155724; font-weight: bold; }
    table.data .pct-warn { color: #856404; font-weight: bold; }
    table.data .pct-bad { color: #721c24; font-weight: bold; }
    table.data .unidad { font-size: 5.5pt; }
    tr.row-1 { background: #fff; }
    tr.row-2 { background: #fdf8e0; }

    .signature {
        width: 100%;
        margin-top: 16px;
        border-collapse: collapse;
    }
    .signature td {
        vertical-align: top;
        padding: 4px 8px;
        text-align: center;
    }
    .signature .role {
        font-weight: bold;
        font-size: 7pt;
    }
    .signature .name {
        font-size: 7pt;
        margin-top: 20px;
    }
    .signature .title {
        font-size: 6.5pt;
    }

    .footer-note {
        margin-top: 10px;
        font-size: 5.5pt;
        font-style: italic;
    }

    .pct-col { min-width: 55px; }
    .avance-col { min-width: 55px; }

    .page-break { page-break-before: always; }
</style>
</head>
<body>
    @php
        $mesesNombres = [1=>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',7=>'JULIO',8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',12=>'DICIEMBRE'];
        $almacenNombre = $filters['almacenSeleccionado']
            ? (\App\Models\Almacen::find($filters['almacenSeleccionado'])->nombre ?? 'CONSOLIDADO')
            : 'CONSOLIDADO';
        $periodoTipo = $data['periodoTipo'] ?? 'mensual';
        $labelPeriodo = $data['labelPeriodo'] ?? 'ENERO';
        $tipoLabel = match ($periodoTipo) {
            'trimestral' => 'TRIMESTRAL',
            'anual' => 'ANUAL',
            default => 'MENSUAL',
        };
        $mesesConfig = $data['config']['meses'] ?? [1];

        function fmt($v, $dec) {
            return number_format((float)$v, $dec, '.', ',');
        }
    @endphp

    <div class="header">
        <div class="header-line">ALIMENTACION PARA EL BIENESTAR</div>
        <div class="header-line">DIRECCIÓN DE OPERACIONES</div>
        <div class="header-line">GERENCIA DE EVALUACIÓN Y PARTICIPACIÓN COMUNITARIA</div>
        <div class="header-line" style="font-size: 11pt; margin-top: 2px;">AVANCES DE PROGRAMA ANUAL DE TRABAJO {{ $filters['anio'] ?? date('Y') }}</div>
    </div>

    <table class="store-info">
        <tr>
            <td class="label">SUCURSAL:</td>
            <td>OAXACA</td>
            <td class="label">ALMACEN:</td>
            <td>{{ $almacenNombre }}</td>
        </tr>
    </table>

    <table class="data" repeat_header="1">
        <thead>
            <tr>
                <th rowspan="2" style="min-width:140px;">COMPROMISO</th>
                <th rowspan="2" style="min-width:80px;"></th>
                <th rowspan="2" style="min-width:55px;">META ANUAL</th>
                <th rowspan="2" style="min-width:65px;">UNIDAD DE MEDIDA</th>
                <th style="min-width:60px;">AVANCE {{ $tipoLabel }}</th>
                <th rowspan="2" style="min-width:60px;" class="pct-col">% DE LOGRO DEL PERIODO</th>
                <th rowspan="2" style="min-width:60px;" class="pct-col">% DE LOGRO SOBRE LA META ANUAL</th>
                <th rowspan="2" style="min-width:70px;">NOTA ACLARATORIA</th>
            </tr>
            <tr>
                <th>{{ $labelPeriodo }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compromisos as $compromiso)
                @php
                    $fila1 = $dataPoa[$compromiso->id][$compromiso->label_fila_1] ?? null;
                    $fila2 = $dataPoa[$compromiso->id][$compromiso->label_fila_2] ?? null;
                    if (!$fila1 && !$fila2) continue;

                    $esPorcentaje = stripos($compromiso->unidad_medida ?? '', 'PORCENTAJE') !== false;
                    $esMoneda = strtoupper($compromiso->unidad_medida ?? '') === 'PESOS';

                    $metaAnual1 = $fila1 ? (float)$fila1->meta_anual : 0;
                    $metaAnual2 = $fila2 ? (float)$fila2->meta_anual : 0;

                    $avance1 = 0;
                    foreach ($mesesConfig as $m) {
                        $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                        $avance1 += $fila1 ? (float)($fila1->$col ?? 0) : 0;
                    }
                    $avance2 = 0;
                    foreach ($mesesConfig as $m) {
                        $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                        $avance2 += $fila2 ? (float)($fila2->$col ?? 0) : 0;
                    }

                    if ($esPorcentaje) {
                        $avance1 = 100;
                    }

                    $pctPeriodo = $avance1 != 0 ? ($avance2 / $avance1) * 100 : 0;
                    $pctAnual = $metaAnual1 != 0 ? ($metaAnual2 / $metaAnual1) * 100 : 0;

                    $pctClass = $pctPeriodo >= 90 ? 'pct-ok' : ($pctPeriodo >= 50 ? 'pct-warn' : 'pct-bad');
                    $pctAClass = $pctAnual >= 90 ? 'pct-ok' : ($pctAnual >= 50 ? 'pct-warn' : 'pct-bad');

                    $dec1 = $esMoneda ? 2 : ($esPorcentaje ? 2 : 0);
                    $dec2 = $esMoneda ? 2 : ($esPorcentaje ? 2 : 0);
                @endphp
                <tr class="row-1">
                    <td class="concept-name" rowspan="2">{{ $compromiso->nombre }}</td>
                    <td>{{ $compromiso->label_fila_1 }}</td>
                    <td class="monto {{ $metaAnual1 == 0 ? '' : '' }}">{{ fmt($metaAnual1, $dec1) }}</td>
                    <td class="unidad" rowspan="2">{{ $compromiso->unidad_medida }}</td>
                    <td class="monto {{ $avance1 == 0 ? '' : '' }}">{{ fmt($avance1, $dec1) }}</td>
                    <td class="monto {{ $pctClass }}">{{ fmt($pctPeriodo, 2) }}%</td>
                    <td class="monto {{ $pctAClass }}">{{ fmt($pctAnual, 2) }}%</td>
                    <td class="left">{{ $fila1->nota_aclaratoria ?? '' }}</td>
                </tr>
                <tr class="row-2">
                    <td>{{ $compromiso->label_fila_2 }}</td>
                    <td class="monto">{{ fmt($metaAnual2, $dec2) }}</td>
                    <td class="monto">{{ fmt($avance2, $dec2) }}</td>
                    <td class="monto {{ $pctClass }}">{{ fmt($pctPeriodo, 2) }}%</td>
                    <td class="monto {{ $pctAClass }}">{{ fmt($pctAnual, 2) }}%</td>
                    <td class="left">{{ $fila2->nota_aclaratoria ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signature">
        <tr>
            <td style="width:33%;">
                <div class="role">ELABORÓ</div>
                <div class="name">LIC. YURI ARIEL SALCIDO MACIAS</div>
                <div class="title">RESPONSABLE DE OPERACIONES</div>
            </td>
            <td style="width:33%;">
                <div class="role">REVISÓ:</div>
                <div class="name">LIC. YURI ARIEL SALCIDO MACIAS</div>
                <div class="title">SUBGERENTE DE OPERACIONES</div>
            </td>
            <td style="width:34%;">
                <div class="role">AUTORIZÓ:</div>
                <div class="name">LIC. ANDREA DEL ROSARIO URIAS SOLIS</div>
                <div class="title">ENCARGADA DEL DESPACHO DE GERENCIA REGIONAL OAXACA</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        NOTA: El formato deberá ser llenado en su totalidad, anotando nombre de la Unidad Operativa y Sucursal (de no contar con todos los datos no se recibirá el reporte); y no deberán modificar las formulas.
    </div>
</body>
</html>
