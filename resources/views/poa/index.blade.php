@extends('layouts.app')

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
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Descargar">
                    <i class="fas fa-download"></i> Descargar
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" id="btn-descargar-xlsx" href="#">
                        <i class="fas fa-file-excel text-success"></i> Excel (.xlsx)
                    </a>
                    <a class="dropdown-item" id="btn-descargar-pdf" href="#">
                        <i class="fas fa-file-pdf text-danger"></i> PDF
                    </a>
                </div>
                <a href="{{ route('importaciones.index') }}" class="btn btn-sm btn-info ml-1" title="Centro de Importación">
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
                    :anio-seleccionado="$anioSeleccionado"
                    :almacen-seleccionado="$almacenSeleccionado"
                    :mostrar-consolidado="$mostrarConsolidado"
                />
            </div>
        </div>
    </div>

    <x-poa.real-modal />
@stop

@section('js')
    <script>
        var RUTA_EXPORT_POA = '{{ route("poa.export") }}';
        var ALMACENES = @json($almacenes->map(function($a) {
            return ['id' => $a->id, 'nombre' => $a->nombre];
        })->values());
    </script>
    @vite('resources/js/poa.js')
    @if(session('success'))
        <script>alert(@json(session('success')));</script>
    @endif
    @if(session('error'))
        <script>alert('Error: ' + @json(session('error')));</script>
    @endif
@stop