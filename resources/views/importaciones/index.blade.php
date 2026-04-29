@extends('adminlte::page')

@section('title', 'Centro de Importación')

@section('css')
    @vite('resources/css/importaciones.css')
@stop

@section('content_header')
    <h1><i class="fas fa-file-import text-institucional-oro"></i> Centro de Importación Homologado</h1>
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
    <!-- BLOQUE 1: ESTADO DE RESULTADOS (PRESUPUESTO) -->
    <div class="col-xl-4 col-lg-6 mb-4">
        <x-importaciones.form-er action="{{ route('importaciones.er') }}" />
    </div>

    <!-- BLOQUE 2: ESTADO DE RESULTADOS (REALIZADO PDF) -->
    <div class="col-xl-4 col-lg-6 mb-4">
        <x-importaciones.form-pdf-realizado />
    </div>

    <!-- BLOQUE 3: VENTAS (REALIZADO VENTAS) -->
    <div class="col-xl-4 col-lg-6 mb-4">
        <x-importaciones.ventas-par-pe :almacenes="$almacenes" />
    </div>
</div>

<div class="row">
    <!-- BLOQUE 4: INFO / ESTADO POA -->
    <div class="col-lg-8 mb-4">
        <x-importaciones.instrucciones />
    </div>
    <div class="col-lg-4 mb-4">
        <x-importaciones.meta-poa />
    </div>
</div>
@stop

@section('js')
    @vite('resources/js/importaciones.js')
@stop