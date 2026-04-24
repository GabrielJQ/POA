@extends('adminlte::page')

@section('title', 'Estado de Resultados')

@section('content_header')
    <h1><i class="fas fa-chart-line text-institucional-verde"></i> Estado de Resultados</h1>
@stop

@section('content')
    {{-- Filtros y Tabla de Resultados --}}
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
            <form id="filtro-form" method="GET" action="{{ route('estado-resultados.index') }}" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <select name="almacen_id" class="form-control">
                            <option value="">Consolidado (Todos los Almacenes)</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="anio" class="form-control" placeholder="Año" value="{{ $anioSeleccionado }}">
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="submit" class="btn btn-info btn-sm mr-1" title="Filtrar">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" id="btn-limpiar" class="btn btn-secondary btn-sm mr-1" title="Limpiar Filtros">
                            <i class="fas fa-trash"></i>
                        </button>
                        <a href="#" id="btn-exportar" class="btn btn-success btn-sm" title="Exportar a Excel">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </div>
                </div>
            </form>

            <div id="contenedor-tabla">
                @include('estado_resultados._tabla')
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Filtrado AJAX
        $('#filtro-form').on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();
            
            let btn = $(this).find('button[type="submit"]');
            let originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            $.ajax({
                url: url,
                data: data,
                success: function(response) {
                    $('#contenedor-tabla').html(response);
                },
                error: function() {
                    alert('Error al filtrar los datos.');
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
            });
        });

        // Botón Limpiar AJAX
        $('#btn-limpiar').on('click', function() {
            $('select[name="almacen_id"]').val('');
            $('input[name="anio"]').val(new Date().getFullYear());
            $('#filtro-form').submit();
        });

        // Exportar
        $('#btn-exportar').on('click', function(e) {
            e.preventDefault();
            let url = '{{ route('estado-resultados.export') }}?' + $('#filtro-form').serialize();
            window.location.href = url;
        });

        // Alertas
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif
        @if(session('error'))
            alert("Error: {{ session('error') }}");
        @endif
    </script>
@stop
