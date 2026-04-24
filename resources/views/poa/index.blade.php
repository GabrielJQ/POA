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
    {{-- Panel de sincronización --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sync-alt"></i> Sincronización desde Estado de Resultados</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('poa.sync') }}" method="POST" class="row align-items-end">
                        @csrf
                        <div class="col-md-4">
                            <label>Almacén</label>
                            <select name="almacen_id" class="form-control">
                                <option value="">Todos los almacenes</option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Año</label>
                            <input type="number" name="anio" class="form-control" value="{{ $anioSeleccionado }}" min="2000" max="2100" required>
                        </div>
                        <div class="col-md-5 text-right">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-sync-alt"></i> Re-sincronizar Metas desde ER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Formato POA --}}
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-table"></i> Formato POA — Metas Comprometidas vs Realizadas</h3>
        </div>
        <div class="card-body p-2">
            {{-- Filtros --}}
            <form id="filtro-poa-form" method="GET" action="{{ route('poa.index') }}" class="mb-3 px-2">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="small font-weight-bold">Almacén</label>
                        <select name="almacen_id" class="form-control form-control-sm">
                            <option value="">Todos los Almacenes</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold">Año</label>
                        <input type="number" name="anio" class="form-control form-control-sm" value="{{ $anioSeleccionado }}">
                    </div>
                    <div class="col-md-3">
                        <label class="small font-weight-bold">Mes a Reportar</label>
                        <select name="mes" class="form-control form-control-sm">
                            @foreach($meses as $numMes => $nombreMes)
                                <option value="{{ $numMes }}" {{ $mesActual == $numMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-right">
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
        // Filtrado AJAX
        $('#filtro-poa-form').on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();

            let btn = $(this).find('button[type="submit"]');
            let originalHtml = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            $.ajax({
                url: url,
                data: data,
                success: function(response) {
                    $('#contenedor-tabla-poa').html(response);
                },
                error: function() {
                    alert('Error al filtrar los datos del POA.');
                },
                complete: function() {
                    btn.html(originalHtml);
                    btn.prop('disabled', false);
                }
            });
        });

        // Limpiar filtros
        $('#btn-limpiar-poa').on('click', function() {
            $('select[name="almacen_id"]').val('');
            $('input[name="anio"]').val(new Date().getFullYear());
            $('select[name="mes"]').val(new Date().getMonth() + 1);
            $('#filtro-poa-form').submit();
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
