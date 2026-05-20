@extends('layouts.app')

@section('title', 'Mi Almacén')

@section('content_header')
    <h1><i class="fas fa-store text-institucional-verde"></i> {{ $almacen->nombre }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resumen {{ $anio }}</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Bienvenido, <strong>{{ auth()->user()->name }}</strong>.</p>
                <p>Desde aquí puedes gestionar la información de tu almacén.</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Acciones rápidas</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('poa.index', ['almacen_id' => $almacen->id]) }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-bullseye"></i> Ir a POA
                </a>
                <a href="{{ route('importaciones.index') }}" class="btn btn-success btn-block mb-2">
                    <i class="fas fa-file-import"></i> Importar datos
                </a>
                <a href="{{ route('estado-resultados.index') }}" class="btn btn-info btn-block mb-2">
                    <i class="fas fa-chart-line"></i> Estado de Resultados
                </a>
                <a href="{{ route('poa.export', ['almacen_id' => $almacen->id]) }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-download"></i> Exportar POA
                </a>
            </div>
        </div>
    </div>
</div>
@stop
