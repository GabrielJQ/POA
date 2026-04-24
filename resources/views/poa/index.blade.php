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
                <button type="button" id="btn-sincronizar-poa" class="btn btn-sm btn-warning" title="Sincronizar datos">
                    <i class="fas fa-sync-alt"></i> Sincronizar
                </button>
                <a href="{{ route('importaciones.index') }}" class="btn btn-sm btn-info" title="Centro de Importación">
                    <i class="fas fa-file-import"></i> Importar Datos
                </a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('poa._filtros')
            <div id="contenedor-tabla-poa">
                @include('poa._tabla')
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        window.POA_Routes = {
            sync: '{{ route("poa.sync") }}'
        };
    </script>
    @vite('resources/js/poa.js')
    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif
    @if(session('error'))
        <script>alert("Error: {{ session('error') }}");</script>
    @endif
@stop