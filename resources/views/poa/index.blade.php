@extends('adminlte::page')

@section('title', 'Programa Anual de Trabajo (POA)')

@section('content_header')
    <h1><i class="fas fa-bullseye text-institucional-oro"></i> Programa Anual de Trabajo (POA)</h1>
@stop

@section('css')
<style>
    /* Estilos específicos del formato POA */
    .poa-table {
        font-size: 0.78rem;
        border-collapse: collapse;
    }
    .poa-table th {
        background-color: var(--gob-verde) !important;
        color: white !important;
        text-align: center;
        vertical-align: middle !important;
        font-size: 0.72rem;
        padding: 6px 8px !important;
        border: 1px solid #0d241f !important;
    }
    .poa-table td {
        padding: 4px 8px !important;
        border: 1px solid #ddd !important;
        vertical-align: middle !important;
    }
    .poa-row-comprometido {
        background-color: #FFF8E7 !important;
    }
    .poa-row-realizado {
        background-color: #FFFFFF !important;
    }
    .poa-concepto-nombre {
        font-weight: 700;
        color: var(--gob-verde);
        text-align: center;
        background-color: #f8f9fa !important;
        border-right: 2px solid var(--gob-oro) !important;
    }
    .poa-tipo-badge {
        font-size: 0.68rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .poa-monto {
        text-align: right;
        font-family: 'Courier New', monospace;
        font-weight: 600;
    }
    .poa-monto-cero {
        color: #999;
    }
    .poa-monto-negativo {
        color: #dc3545;
    }
    .poa-unidad {
        text-align: center;
        font-size: 0.68rem;
        color: var(--gob-gris-oscuro);
        font-weight: 600;
    }
    .poa-pct {
        text-align: center;
        font-weight: 600;
    }
    .poa-pct-ok { color: #28a745; }
    .poa-pct-warn { color: #ffc107; }
    .poa-pct-bad { color: #dc3545; }
    .poa-nota {
        font-size: 0.65rem;
        color: #666;
        max-width: 120px;
    }
</style>
@stop

@section('content')
    {{-- Formato POA --}}
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
            {{-- Filtros --}}
            <form id="filtro-poa-form" method="GET" action="{{ route('poa.index') }}" class="mb-3 px-2" onsubmit="return false;">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="small font-weight-bold">Consolidado</label>
                        <select name="consolidado" class="form-control form-control-sm" id="consolidado-select">
                            <option value="si" {{ $mostrarConsolidado === true ? 'selected' : '' }}>Todos los Almacenes</option>
                            <option value="no" {{ $mostrarConsolidado === false ? 'selected' : '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="div-almacen">
                        <label class="small font-weight-bold">Almacén</label>
                        <select name="almacen_id" class="form-control form-control-sm">
                            <option value="">Seleccionar...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="small font-weight-bold">Año</label>
                        <input type="number" name="anio" class="form-control form-control-sm" value="{{ $anioSeleccionado }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold">Período</label>
                        <select name="periodo" class="form-control form-control-sm" id="periodo-select">
                            <option value="mensual" {{ $periodoTipo === 'mensual' ? 'selected' : '' }}>Mensual</option>
                            <option value="trimestral" {{ $periodoTipo === 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                            <option value="anual" {{ $periodoTipo === 'anual' ? 'selected' : '' }}>Anual</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="div-trimestre" style="display: {{ $periodoTipo === 'trimestral' ? 'block' : 'none' }}">
                        <label class="small font-weight-bold">Trimestre</label>
                        <select name="trimestre" class="form-control form-control-sm">
                            @foreach($trimestres as $num => $nombre)
                                <option value="{{ $num }}" {{ $trimestreSeleccionado == $num ? 'selected' : '' }}>{{ $num }}: {{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2" id="div-mes" style="display: {{ $periodoTipo === 'mensual' ? 'block' : 'none' }}">
                        <label class="small font-weight-bold">Mes</label>
                        <select name="mes" class="form-control form-control-sm">
                            @foreach($meses as $numMes => $nombreMes)
                                <option value="{{ $numMes }}" {{ $mesActual == $numMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 text-right">
                        <button type="submit" class="btn btn-info btn-sm mr-1" title="Filtrar">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" id="btn-limpiar-poa" class="btn btn-secondary btn-sm" title="Limpiar Filtros">
                            <i class="fas fa-eraser"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div id="contenedor-tabla-poa">
                @include('poa._tabla')
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Configurar CSRF token y headers para todas las peticiones AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // Mostrar/ocultar campo almacén según consolidado
        function toggleAlmacen() {
            var consolidado = $('#consolidado-select').val();
            if (consolidado === 'si') {
                $('#div-almacen').hide();
                $('select[name="almacen_id"]').val('');
            } else {
                $('#div-almacen').show();
            }
        }

// Inicializar estado de campos al cargar página
        $(document).ready(function() {
            toggleAlmacen();
        });

        // Botón de sincronizar
        $('#btn-sincronizar-poa').on('click', function() {
            var btn = $(this);
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("poa.sync") }}',
                method: 'POST',
                data: {
                    anio: $('input[name="anio"]').val() || new Date().getFullYear(),
                    almacen_id: $('select[name="almacen_id"]').val() || '',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message || 'Sincronización completada');
                    cargarTablaPOA();
                },
                error: function(xhr) {
                    alert('Error al sincronizar: ' + (xhr.responseJSON?.message || 'Error desconocido'));
                },
                complete: function() {
                    btn.html('<i class="fas fa-sync-alt"></i> Sincronizar');
                    btn.prop('disabled', false);
                }
            });
        });

        // Cambio en consolidado - muestra/ocultar almacén y recarga
        $('#consolidado-select').on('change', function() {
            toggleAlmacen();
            cargarTablaPOA();
        });

        // Cambio en período - muestra/oculta campos y recarga
        $('#periodo-select').on('change', function() {
            var periodo = $(this).val();
            $('#div-mes').hide();
            $('#div-trimestre').hide();
            if (periodo === 'mensual') {
                $('#div-mes').show();
            } else if (periodo === 'trimestral') {
                $('#div-trimestre').show();
            }
            cargarTablaPOA();
        });

        // Cambio en otros selects (mes, año, almacén) - recarga directo
        $('#filtro-poa-form').on('change', 'select[name="mes"], select[name="anio"], select[name="almacen_id"], select[name="trimestre"]', function() {
            cargarTablaPOA();
        });

        // Función centralizada para cargar la tabla
        var cargandoTabla = false;
        function cargarTablaPOA() {
            if (cargandoTabla) return;
            cargandoTabla = true;
            
            var url = $('#filtro-poa-form').attr('action');
            var data = $('#filtro-poa-form').serialize();

            var btn = $('#filtro-poa-form').find('button[type="submit"]');
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            $.ajax({
                url: url,
                data: data,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#contenedor-tabla-poa').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', status, error);
                    alert('Error al filtrar los datos del POA.');
                },
                complete: function() {
                    btn.html('<i class="fas fa-search"></i>');
                    btn.prop('disabled', false);
                    cargandoTabla = false;
                }
            });
        }

        // Limpiar filtros
        $('#btn-limpiar-poa').on('click', function() {
            $('select[name="consolidado"]').val('si');
            $('select[name="almacen_id"]').val('');
            $('input[name="anio"]').val(new Date().getFullYear());
            $('select[name="periodo"]').val('mensual');
            $('select[name="trimestre"]').val(Math.ceil((new Date().getMonth() + 1) / 3));
            $('select[name="mes"]').val(new Date().getMonth() + 1);
            toggleAlmacen();
            $('#div-mes').show();
            $('#div-trimestre').hide();
            cargarTablaPOA();
        });

        // También capturar el botón de lupa directamente
        $('#filtro-poa-form button[type="submit"]').on('click', function(e) {
            e.preventDefault();
            cargarTablaPOA();
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
