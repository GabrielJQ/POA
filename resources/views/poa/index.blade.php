@extends('adminlte::page')

@section('title', 'Programa Anual de Trabajo (POA)')

@section('css')
    @vite('resources/css/poa.css')
@stop

@section('content_header')
    <h1><i class="fas fa-bullseye text-institucional-oro"></i> Programa Anual de Trabajo (POA)</h1>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-table"></i> Formato POA — Metas Comprometidas vs Realizadas</h3>
            <div>
                <a href="{{ route('importaciones.index') }}" class="btn btn-sm btn-info" title="Centro de Importación">
                    <i class="fas fa-file-import"></i> Importar Datos
                </a>
            </div>
        </div>
        <div class="card-body p-2">
            <x-poa.filtros
                :almacenes="$almacenes"
                :mostrar-consolidado="$mostrarConsolidado"
                :almacen-seleccionado="$almacenSeleccionado"
                :anio-seleccionado="$anioSeleccionado"
                :periodo-tipo="$periodoTipo"
                :trimestre-seleccionado="$trimestreSeleccionado"
                :mes-actual="$mesActual"
                :trimestres="$trimestres"
                :meses="$meses"
            />
            <div id="contenedor-tabla-poa">
                <x-poa.tabla
                    :compromisos="$compromisos"
                    :data-poa="$dataPoa"
                    :config="$config"
                    :label-periodo="$labelPeriodo"
                />
            </div>
        </div>
    </div>
@stop

@section('js')
    @vite('resources/js/poa.js')
    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif
    @if(session('error'))
        <script>alert("Error: {{ session('error') }}");</script>
    @endif
@stop