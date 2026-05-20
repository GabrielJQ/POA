@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
    <h1><i class="fas fa-tachometer-alt text-institucional-verde"></i> Dashboard Operativo</h1>
@stop

@section('css')
    <style>
        .dashboard-card { border-radius: 10px; transition: transform 0.2s; }
        .dashboard-card:hover { transform: translateY(-3px); }
        .stat-card { border-left: 4px solid var(--gob-verde); }
        .stat-card-blue { border-left-color: #007bff; }
        .stat-card-orange { border-left-color: #fd7e14; }
        .stat-card-red { border-left-color: #dc3545; }
        .stat-card-purple { border-left-color: #6f42c1; }
        .stat-icon { font-size: 2rem; opacity: 0.8; }
        .stat-value { font-size: 1.8rem; font-weight: 700; }
        .indice-bar { height: 10px; border-radius: 5px; }
        .indice-label { font-size: 0.85rem; font-weight: 600; }
        .rank-medal { font-size: 1.5rem; }
        .alert-badge { display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; }
        .alert-badge-red { background-color: #f8d7da; color: #721c24; }
        .alert-badge-orange { background-color: #ffe0b2; color: #e65100; }
        .alert-badge-yellow { background-color: #fff3cd; color: #856404; }
        .alert-badge-green { background-color: #d4edda; color: #155724; }
        .alert-badge-gray { background-color: #e2e3e5; color: #383d41; }
        .bg-orange { background-color: #fd7e14 !important; }
        .text-orange { color: #e65100 !important; }
        .detalle-row { display: none; }
        .detalle-row.show { display: table-row; }
        .expand-icon { cursor: pointer; user-select: none; }
    </style>
@stop

@section('content')
{{-- Fila 1: Tarjetas de resumen --}}
<div class="row">
    <div class="col">
        <div class="card stat-card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Almacenes</p>
                        <h2 class="stat-value mb-0">{{ $totalAlmacenes }}</h2>
                        <small class="text-muted">{{ $totalConDatos }} con datos</small>
                    </div>
                    <div class="stat-icon text-institucional-verde">
                        <i class="fas fa-warehouse"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        @php
            $consolidadoColor = $indiceConsolidado >= 70 ? 'success' : ($indiceConsolidado >= 40 ? 'warning' : 'danger');
        @endphp
        <div class="card stat-card stat-card-{{ $consolidadoColor === 'success' ? 'blue' : ($consolidadoColor === 'warning' ? 'orange' : 'red') }} dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Eficiencia Global</p>
                        <h2 class="stat-value mb-0 text-{{ $consolidadoColor }}">
                            {{ number_format($indiceConsolidado, 1) }}%
                        </h2>
                        <small class="text-muted">{{ $anioActual }}</small>
                    </div>
                    <div class="stat-icon text-{{ $consolidadoColor }}">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-{{ $consolidadoColor }}" style="width: {{ min($indiceConsolidado, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card stat-card-blue dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Verde</p>
                        <h2 class="stat-value mb-0 text-success">{{ count($verde) }}</h2>
                        <small class="text-muted">≥ 75%</small>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card stat-card-orange dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Ámbar</p>
                        <h2 class="stat-value mb-0 text-warning">{{ count($amarillo) }}</h2>
                        <small class="text-muted">50-75%</small>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card stat-card-red dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Naranja</p>
                        <h2 class="stat-value mb-0 text-orange">{{ count($naranja) }}</h2>
                        <small class="text-muted">30-50%</small>
                    </div>
                    <div class="stat-icon text-orange">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card stat-card-red dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Rojo</p>
                        <h2 class="stat-value mb-0 text-danger">{{ count($rojo) }}</h2>
                        <small class="text-muted">&lt; 30%</small>
                    </div>
                    <div class="stat-icon text-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Fila 2: Almacenes en Rojo + Top 3/Bottom 3 --}}
<div class="row mt-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list text-danger"></i> Almacenes por Índice de Eficiencia</h3>
            </div>
            <div class="card-body p-2">
                @if(count($indicePorAlmacen) > 0)
                    @foreach($indicePorAlmacen as $item)
                        @php
                            $idx = $item['indice'];
                            $badgeClass = $idx === null ? 'alert-badge-gray' : ($idx >= 75 ? 'alert-badge-green' : ($idx >= 50 ? 'alert-badge-yellow' : ($idx >= 30 ? 'alert-badge-orange' : 'alert-badge-red')));
                            $badgeText = $idx === null ? 'Sin datos' : (number_format($idx, 1) . '%');
                            $barColor = $idx === null ? 'secondary' : ($idx >= 75 ? 'success' : ($idx >= 50 ? 'warning' : ($idx >= 30 ? 'orange' : 'danger')));
                            $barWidth = $idx === null ? 0 : min($idx, 100);
                        @endphp
                        <div class="mb-2 px-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="indice-label">
                                    <i class="fas fa-store text-muted mr-1"></i> {{ $item['nombre'] }}
                                </span>
                                <span class="alert-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                            <div class="progress indice-bar">
                                <div class="progress-bar bg-{{ $barColor }}" style="width: {{ $barWidth }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay datos disponibles</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-traffic-light"></i> Semáforo de Eficiencia</h3>
            </div>
            <div class="card-body">
                @php
                    $categorias = [
                        ['class' => 'success', 'icon' => 'fa-check-circle', 'stores' => $verde, 'rango' => '≥ 75%'],
                        ['class' => 'warning', 'icon' => 'fa-exclamation-circle', 'stores' => $amarillo, 'rango' => '50-75%'],
                        ['class' => 'orange', 'icon' => 'fa-exclamation-triangle', 'stores' => $naranja, 'rango' => '30-50%'],
                        ['class' => 'danger', 'icon' => 'fa-times-circle', 'stores' => $rojo, 'rango' => '< 30%'],
                    ];
                @endphp
                @foreach($categorias as $cat)
                    @php $sc = $cat['stores']; @endphp
                    <div class="mb-3 p-2 rounded" style="background-color: {{ $cat['class'] === 'success' ? '#d4edda' : ($cat['class'] === 'warning' ? '#fff3cd' : ($cat['class'] === 'orange' ? '#ffe0b2' : '#f8d7da')) }};">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>
                                <i class="fas {{ $cat['icon'] }} text-{{ $cat['class'] === 'orange' ? 'orange' : $cat['class'] }}"></i>
                                <small class="text-muted">({{ $cat['rango'] }})</small>
                            </span>
                            <span class="badge bg-{{ $cat['class'] === 'orange' ? 'orange' : $cat['class'] }} text-white">{{ count($sc) }}</span>
                        </div>
                        @if(count($sc) > 0)
                            @foreach($sc as $store)
                                <div class="d-flex justify-content-between align-items-center ml-3 py-0 small">
                                    <span>{{ $store['nombre'] }}</span>
                                    <span class="font-weight-bold text-{{ $cat['class'] === 'orange' ? 'orange' : $cat['class'] }}">
                                        {{ number_format($store['indice'], 1) }}%
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-muted small ml-3">Sin almacenes en esta categoría</div>
                        @endif
                    </div>
                @endforeach
                @if($totalSinDatos > 0)
                    <div class="text-muted small text-center">
                        <i class="fas fa-minus-circle"></i> {{ $totalSinDatos }} almacén(es) sin datos
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Fila 3: Tabla detallada --}}
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-table"></i> Detalle de Eficiencia por Almacén</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-institucional-verde text-white">
                            <tr>
                                <th style="width: 30px;"></th>
                                <th>Almacén</th>
                                <th class="text-center" style="width: 120px;">Índice Global</th>
                                <th style="width: 200px;">Barra</th>
                                <th class="text-center" style="width: 100px;">Conceptos</th>
                                <th style="width: 80px;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indicePorAlmacen as $index => $item)
                                @php
                                    $idx = $item['indice'];
                                    $rowColor = $idx === null ? '' : ($idx >= 75 ? 'table-success' : ($idx >= 50 ? '' : ($idx >= 30 ? 'table-warning' : 'table-danger')));
                                    $barColor = $idx === null ? 'secondary' : ($idx >= 75 ? 'success' : ($idx >= 50 ? 'warning' : ($idx >= 30 ? 'orange' : 'danger')));
                                    $barWidth = $idx === null ? 0 : min($idx, 100);
                                @endphp
                                <tr class="{{ $rowColor }}">
                                    <td class="text-center expand-icon" onclick="toggleDetalle({{ $index }})">
                                        <i class="fas fa-plus-circle text-primary" id="icon-{{ $index }}"></i>
                                    </td>
                                    <td class="font-weight-bold">{{ $item['nombre'] }}</td>
                                    <td class="text-center font-weight-bold">
                                        {{ $idx !== null ? number_format($idx, 1) . '%' : '—' }}
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $barColor }}" style="width: {{ $barWidth }}%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item['numConceptos'] }}</td>
                                    <td class="text-center">
                                        @if(count($item['detalles']) > 0)
                                            <span class="badge bg-info text-white">{{ count($item['detalles']) }} conceptos</span>
                                        @else
                                            <span class="badge bg-secondary text-white">Sin datos</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="detalle-row" id="detalle-{{ $index }}">
                                    <td colspan="6" class="p-0">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th style="width: 40%; padding-left: 40px;">Concepto</th>
                                                    <th class="text-right" style="width: 20%;">META</th>
                                                    <th class="text-right" style="width: 20%;">REAL</th>
                                                    <th class="text-center" style="width: 20%;">% Logro</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($item['detalles'] as $det)
                                                    @php
                                                        $pctColor = $det['pct'] >= 70 ? 'success' : ($det['pct'] >= 40 ? 'warning' : 'danger');
                                                        $esPorcentajeDet = $det['unidad_medida'] && stripos($det['unidad_medida'], 'PORCENTAJE') !== false;
                                                        $esMonedaDet = ($det['unidad_medida'] ?? '') === 'PESOS';
                                                    @endphp
                                                    <tr>
                                                        <td style="padding-left: 40px;">{{ $det['concepto'] }}</td>
                                                        <td class="text-right font-weight-bold">
                                                            @if($esPorcentajeDet)
                                                                {{ number_format($det['meta'], 0) }}%
                                                            @elseif($esMonedaDet)
                                                                ${{ number_format($det['meta'], 2) }}
                                                            @else
                                                                {{ number_format($det['meta'], 0) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            @if($esPorcentajeDet)
                                                                {{ number_format($det['real'], 2) }}%
                                                            @elseif($esMonedaDet)
                                                                ${{ number_format($det['real'], 2) }}
                                                            @else
                                                                {{ number_format($det['real'], 0) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center font-weight-bold text-{{ $pctColor }}">
                                                            {{ number_format($det['pct'], 1) }}%
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">Sin datos de conceptos</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    window.toggleDetalle = function(index) {
        var row = document.getElementById('detalle-' + index);
        var icon = document.getElementById('icon-' + index);
        if (row.classList.contains('show')) {
            row.classList.remove('show');
            icon.className = 'fas fa-plus-circle text-primary';
        } else {
            row.classList.add('show');
            icon.className = 'fas fa-minus-circle text-primary';
        }
    };
</script>
@stop
