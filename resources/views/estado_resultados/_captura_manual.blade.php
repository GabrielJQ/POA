<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Captura Manual</h3>
    </div>
    <form action="{{ route('estado-resultados.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Almacén</label>
                        <select name="almacen_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Concepto</label>
                        <select name="concepto_er_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($conceptos as $concepto)
                                <option value="{{ $concepto->id }}">{{ $concepto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Mes (1-12)</label>
                        <input type="number" name="mes" class="form-control" min="1" max="12" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Registro</button>
        </div>
    </form>
</div>
