@extends('adminlte::page')

@section('title', 'Centro de Importación')

@section('css')
    @vite('resources/css/importaciones.css')
@stop

@section('content_header')
    <h1><i class="fas fa-file-import text-institucional-oro"></i> Centro de Importación</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-import alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-import alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card import-card">
            <div class="card-header bg-institucional-verde text-white">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Importar Estado de Resultados</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('importaciones.er') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Año fiscal</label>
                        <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
                        <small class="text-muted">Año del cual quieres importar los datos</small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Archivo Excel</label>
                        <div class="drop-zone" id="drop-zone-er">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Arrastra el archivo o haz clic para seleccionar</p>
                            <small class="text-muted">Formatos: .xlsx, .xls, .csv</small>
                            <input type="file" name="archivo" id="archivo-er" accept=".xlsx,.xls,.csv" style="display:none" required>
                        </div>
                        <div id="filename-er" class="mt-2 text-muted small"></div>
                    </div>
                    <button type="submit" class="btn btn-success btn-import btn-block">
                        <i class="fas fa-process"></i> Procesar Estado de Resultados
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card import-card import-card-poa">
            <div class="card-header" style="background-color: var(--gob-oro); color: white;">
                <h3 class="card-title"><i class="fas fa-bullseye"></i> Metas POA</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Sincronización automática</strong>
                </div>
                <p class="text-muted">
                    Las metas POA se sincronizan automáticamente al importar el Estado de Resultados.
                    No necesitas hacer nada extra.
                </p>
                <hr>
                <h5 class="font-weight-bold">¿Cómo funciona?</h5>
                <ol class="small text-muted">
                    <li>Importas el archivo Estado de Resultados</li>
                    <li>El sistema detecta los almacenes automáticamente</li>
                    <li>La sincronización POA es automática</li>
                    <li>Puedes ver los resultados en "Formato POA"</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Instrucciones</h3>
            </div>
            <div class="card-body">
                <h5>Estado de Resultados</h5>
                <ul>
                    <li>Sube el archivo Excel del Estado de Resultados con la estructura estándar.</li>
                    <li>El sistema identificará el almacén y la unidad operativa automáticamente.</li>
                    <li>Los datos se guardarán en la base de datos.</li>
                    <li><strong>La sincronización con POA es automática tras importar.</strong></li>
                </ul>
                <h5 class="mt-3">Formato POA</h5>
                <ul>
                    <li>Accede a "Formato POA" para ver las metas vsrealizado.</li>
                    <li>Los datos ya están sincronizados del ER.</li>
                    <li>Usa los filtros para периодо y consolidado.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    @vite('resources/js/importaciones.js')
@stop