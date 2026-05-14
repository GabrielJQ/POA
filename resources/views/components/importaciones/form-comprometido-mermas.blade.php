<div class="card import-card import-card-danger">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-hand-holding-usd"></i> Mermas, Quebrantos y Mal Estado</h3>
        <span class="badge bg-white text-secondary font-weight-bold" style="font-size:0.7rem;">REALIZADO (Conc. 8) — Por Trimestre</span>
    </div>
    <div class="card-body d-flex flex-column">
        <form action="{{ route('importaciones.mermas-comprometido') }}" method="POST" class="d-flex flex-column flex-fill">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Almacén</label>
                        <select name="almacen_id" class="form-control" required>
                            <option value="">Almacén...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Año</label>
                        <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Trimestre</label>
                        <select name="trimestre" class="form-control" required>
                            <option value="">Trime...</option>
                            <option value="1">Q1</option>
                            <option value="2">Q2</option>
                            <option value="3">Q3</option>
                            <option value="4">Q4</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Monto</label>
                        <input type="number" name="monto" class="form-control" step="0.01" lang="en" placeholder="0.00" required>
                    </div>
                </div>
            </div>
            <div class="alert alert-guinda small mt-1">
                <i class="fas fa-hand-holding-usd"></i>
                El valor trimestral se distribuirá en partes iguales entre los 3 meses del trimestre seleccionado. Alimenta el <strong>REALIZADO</strong> del concepto 8.
            </div>
            <button type="submit" class="btn btn-oro btn-import btn-block mt-auto">
                <i class="fas fa-save"></i> Guardar
            </button>
        </form>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="number"][lang="en"]');
    inputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.value !== '') {
                let val = this.value.replace(',', '.');
                let num = parseFloat(val);
                if (!isNaN(num)) {
                    this.value = num.toFixed(2);
                }
            }
        });
    });
});
</script>
@endpush
