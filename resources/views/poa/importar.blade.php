@extends('adminlte::page')

@section('title', 'Importar Datos POA')

@section('content_header')
    <h1>Carga de Movimientos (Incrementos / Decrementos)</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Seleccionar Archivo Excel/CSV</h3>
            </div>
            <form action="{{ route('importar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Tipo de Movimiento</label>
                        <select name="tipo" class="form-control" required>
                            <option value="incremento">Incremento de Capital</option>
                            <option value="decremento">Decremento de Capital</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="archivo">Archivo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="archivo" class="custom-file-input" id="archivo" required>
                                <label class="custom-file-label" for="archivo">Elegir archivo...</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Procesar Importación
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Instrucciones</span>
                <span class="info-box-number">Asegúrate que el Excel tenga las columnas:</span>
                <p>folio, numero_tienda, fecha, costo, venta</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@stop