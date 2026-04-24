@extends('adminlte::page')

@section('title', 'Dashboard - Operaciones')

@section('content_header')
    <h1><i class="fas fa-tachometer-alt text-institucional-verde"></i> Dashboard Operativo</h1>
@stop

@section('css')
<style>
    .dashboard-card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .dashboard-card:hover {
        transform: translateY(-3px);
    }
    .stat-card {
        border-left: 4px solid var(--gob-verde);
    }
    .stat-card-blue {
        border-left-color: #007bff;
    }
    .stat-card-orange {
        border-left-color: #fd7e14;
    }
    .stat-card-purple {
        border-left-color: #6f42c1;
    }
    .stat-icon {
        font-size: 2rem;
        opacity: 0.8;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
    }
    .chart-container {
        position: relative;
        height: 250px;
    }
    .progress-percentage {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .small-chart {
        height: 180px;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card stat-card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Almacenes</p>
                        <h2 class="stat-value mb-0">{{ $totalAlmacenes }}</h2>
                    </div>
                    <div class="stat-icon text-institucional-verde">
                        <i class="fas fa-warehouse"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card stat-card-blue dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Registros ER</p>
                        <h2 class="stat-value mb-0">{{ number_format($registrosER) }}</h2>
                    </div>
                    <div class="stat-icon text-primary">
                        <i class="fas fa-chart-line"></i>
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
                        <p class="text-muted mb-0">Compromisos</p>
                        <h2 class="stat-value mb-0">{{ $compromisosActivos }}</h2>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card stat-card-purple dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Cumplimiento</p>
                        <h2 class="stat-value mb-0">{{ number_format($porcentajeCumplimiento, 1) }}%</h2>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Top 5 Almacenes - {{ $anioActual }}</h3>
            </div>
            <div class="card-body">
                @if($porAlmacen->count() > 0)
                    @foreach($porAlmacen as $index => $item)
                        @php $porcentaje = $porAlmacen->max('monto') > 0 ? ($item->monto / $porAlmacen->max('monto')) * 100 : 0 @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="font-weight-bold">{{ $index + 1 }}. {{ $item->nombre }}</span>
                                <span class="text-muted">${{ number_format($item->monto, 0) }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-institucional-verde" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay datos disponibles</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Top 5 Conceptos ER - Mes {{ $mesActual }}</h3>
            </div>
            <div class="card-body">
                @if($porConceptoER->count() > 0)
                    @foreach($porConceptoER as $index => $item)
                        @php $porcentaje = $porConceptoER->max('monto') > 0 ? ($item->monto / $porConceptoER->max('monto')) * 100 : 0 @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="font-weight-bold">{{ $index + 1 }}. {{ Str::limit($item->nombre, 25) }}</span>
                                <span class="text-muted">${{ number_format($item->monto, 0) }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-institucional-oro" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay datos disponibles</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Evolución Mensual ER - {{ $anioActual }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-institucional-verde text-white">
                            <tr>
                                <th>Concepto</th>
                                @for($m = 1; $m <= 12; $m++)
                                    <th class="text-center">{{ strtoupper(substr($meses[$m] ?? '', 0, 3)) }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $conceptos = \App\Models\ConceptoER::orderBy('orden_visual')->limit(10)->get();
                            @endphp
                            @foreach($conceptos as $concepto)
                                <tr>
                                    <td>{{ Str::limit($concepto->nombre, 20) }}</td>
                                    @for($m = 1; $m <= 12; $m++)
                                        @php
                                        $monto = \App\Models\ResultadoMensual::where('anio', $anioActual)
                                            ->where('mes', $m)
                                            ->where('concepto_er_id', $concepto->id)
                                            ->sum('monto');
                                        @endphp
                                        <td class="text-right">{{ $monto > 0 ? '$'.number_format($monto, 0) : '-' }}</td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-link"></i> Accesos Rápidos</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('importaciones.index') }}" class="btn btn-lg btn-outline-primary btn-block">
                            <i class="fas fa-file-import"></i><br>Centro de Importación
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('estado-resultados.index') }}" class="btn btn-lg btn-outline-success btn-block">
                            <i class="fas fa-chart-line"></i><br>Estado de Resultados
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('poa.index') }}" class="btn btn-lg btn-outline-warning btn-block">
                            <i class="fas fa-bullseye"></i><br>Formato POA
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="#" class="btn btn-lg btn-outline-secondary btn-block">
                            <i class="fas fa-cog"></i><br>Configuración
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop