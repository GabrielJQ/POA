@extends('adminlte::page')

@section('title', 'Estado de Resultados')

@section('content_header')
    <h1><i class="fas fa-chart-line text-institucional-verde"></i> Estado de Resultados</h1>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-table"></i> Estado de Resultados Proforma</h3>
            <div>
                <a href="{{ route('importaciones.index') }}" class="btn btn-sm btn-warning" title="Centro de Importación">
                    <i class="fas fa-file-import"></i> Importar Datos
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('estado_resultados._filtros')
            <div id="contenedor-tabla">
                @include('estado_resultados._tabla')
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        window.ER_Routes = {
            export: '{{ route("estado-resultados.export") }}'
        };
    </script>
    @vite('resources/js/er.js')
    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif
    @if(session('error'))
        <script>alert("Error: {{ session('error') }}");</script>
    @endif
@stop