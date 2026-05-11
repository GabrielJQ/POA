@extends('adminlte::page')

@section('title', 'Dashboard Operativo')

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
        .alert-badge-yellow { background-color: #fff3cd; color: #856404; }
        .alert-badge-green { background-color: #d4edda; color: #155724; }
        .alert-badge-gray { background-color: #e2e3e5; color: #383d41; }
        .detalle-row { display: none; }
        .detalle-row.show { display: table-row; }
        .expand-icon { cursor: pointer; user-select: none; }
    </style>
@stop

@section('content')
{{-- Fila 1: Tarjetas de resumen --}}
<div class="row">
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
        <div class="card stat-card stat-card-red dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">En Rojo</p>
                        <h2 class="stat-value mb-0 text-danger">{{ $enRojo }}</h2>
                        <small class="text-muted">Índice &lt; 30%</small>
                    </div>
                    <div class="stat-icon text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card stat-card-orange dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Atención</p>
                        <h2 class="stat-value mb-0 text-warning">{{ $enAtencion }}</h2>
                        <small class="text-muted">Índice 30-50%</small>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="fas fa-exclamation-circle"></i>
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
                            $badgeClass = $idx === null ? 'alert-badge-gray' : ($idx < 30 ? 'alert-badge-red' : ($idx < 50 ? 'alert-badge-yellow' : 'alert-badge-green'));
                            $badgeText = $idx === null ? 'Sin datos' : (number_format($idx, 1) . '%');
                            $barColor = $idx === null ? 'secondary' : ($idx < 30 ? 'danger' : ($idx < 50 ? 'warning' : 'success'));
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
                <h3 class="card-title"><i class="fas fa-trophy text-warning"></i> Top 3 / Bottom 3</h3>
            </div>
            <div class="card-body">
                @if(count($top3) > 0)
                    <p class="font-weight-bold text-success mb-2"><i class="fas fa-arrow-up"></i> Mejores</p>
                    @foreach($top3 as $i => $item)
                        @php $medals = ['🥇', '🥈', '🥉']; @endphp
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span><span class="rank-medal">{{ $medals[$i] ?? '' }}</span> {{ $item['nombre'] }}</span>
                            <span class="font-weight-bold text-success">{{ number_format($item['indice'], 1) }}%</span>
                        </div>
                    @endforeach
                    <hr>
                    <p class="font-weight-bold text-danger mb-2"><i class="fas fa-arrow-down"></i> Peores</p>
                    @foreach($bottom3 as $item)
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span><span class="rank-medal">⚠️</span> {{ $item['nombre'] }}</span>
                            <span class="font-weight-bold text-danger">{{ number_format($item['indice'], 1) }}%</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay datos disponibles</p>
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
                                    $rowColor = $idx === null ? '' : ($idx < 30 ? 'table-danger' : ($idx < 50 ? 'table-warning' : ''));
                                    $barColor = $idx === null ? 'secondary' : ($idx < 30 ? 'danger' : ($idx < 50 ? 'warning' : 'success'));
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
                                                    @endphp
                                                    <tr>
                                                        <td style="padding-left: 40px;">{{ $det['concepto'] }}</td>
                                                        <td class="text-right font-weight-bold">
                                                            @if($det['meta'] == 100 && stripos($det['concepto'] ?? '', 'OPORTUNIDAD') !== false)
                                                                {{ number_format($det['meta'], 0) }}%
                                                            @elseif($det['meta'] == 100 && stripos($det['concepto'] ?? '', 'EFICIENCIA') !== false)
                                                                {{ number_format($det['meta'], 0) }}%
                                                            @else
                                                                ${{ number_format($det['meta'], 2) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            @if($det['meta'] == 100)
                                                                {{ number_format($det['real'], 2) }}%
                                                            @else
                                                                ${{ number_format($det['real'], 2) }}
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
