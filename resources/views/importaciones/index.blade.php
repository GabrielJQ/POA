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
        <x-importaciones.form-er action="{{ route('importaciones.er') }}" />
    </div>

    <div class="col-md-6">
        <x-importaciones.meta-poa />
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <x-importaciones.ventas-par-pe :almacenes="$almacenes" />
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <x-importaciones.instrucciones />
    </div>
</div>
@stop

@section('js')
    @vite('resources/js/importaciones.js')
@stop