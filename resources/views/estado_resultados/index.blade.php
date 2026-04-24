@extends('adminlte::page')

@section('title', 'Estado de Resultados')

@section('content_header')
    <h1>Estado de Resultados</h1>
@stop

@section('content')
    <div class="row">
        <!-- Tarjeta de Importación Masiva -->
        <div class="col-md-6">
            @include('estado_resultados._importar')
        </div>

        <!-- Tarjeta de Captura Manual -->
        <div class="col-md-6">
            @include('estado_resultados._captura_manual')
        </div>
    </div>

    <!-- Filtros y Tabla de Resultados -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-table"></i> Estado de Resultados Proforma (Vista Excel)</h3>
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
        // Actualizar label de input file al seleccionar archivo
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Filtrado AJAX
        $('#filtro-form').on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();
            
            // Botón en estado de carga
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

        // Botón Exportar Excel
        $('#btn-exportar').on('click', function(e) {
            e.preventDefault();
            let data = $('#filtro-form').serialize();
            window.location.href = '{{ route("estado-resultados.export") }}?' + data;
        });

        // Alertas con SweetAlert2 o JS nativo
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif
        @if(session('error'))
            alert("Error: {{ session('error') }}");
        @endif
        @if ($errors->any())
            alert("Errores en el formulario:\n- {{ implode('\n- ', $errors->all()) }}");
        @endif
    </script>
@stop
