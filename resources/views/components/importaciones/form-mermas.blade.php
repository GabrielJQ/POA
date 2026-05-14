<div class="card import-card import-card-orange">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-weight-hanging"></i> Mermas, Quebrantos y Mal Estado</h3>
        <span class="badge bg-white text-secondary font-weight-bold" style="font-size:0.7rem;">COMPROMETIDO (Conc. 8)</span>
    </div>
    <div class="card-body d-flex flex-column">
        <form action="{{ route('importaciones.mermas') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-fill">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <label for="archivo-mermas" class="upload-area upload-area-orange" id="zone-upload-mermas" style="display: block;">
                    <i class="fas fa-file-excel fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic aquí</p>
                    <small class="text-muted">Formatos: Excel (.xlsx, .xls)</small>
                </label>
                <input type="file" name="archivo" id="archivo-mermas" accept=".xlsx,.xls" style="display:none" required>
                <div id="filename-mermas" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-guinda small mt-1">
                <i class="fas fa-calculator"></i>
                Calcula el comprometido de mermas a partir de las ventas por línea y porcentajes configurados. Alimenta el <strong>COMPROMETIDO</strong> del concepto 8.
            </div>
            <button type="submit" class="btn btn-oro btn-import btn-block mt-auto">
                <i class="fas fa-upload"></i> Importar
            </button>
        </form>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('archivo-mermas');
    const zone = document.getElementById('zone-upload-mermas');
    const filename = document.getElementById('filename-mermas');

    zone.addEventListener('click', function(e) {
        e.preventDefault();
        input.click();
    });

    zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        zone.style.borderColor = '#fd7e14';
    });

    zone.addEventListener('dragleave', function() {
        zone.style.borderColor = '#ccc';
    });

    zone.addEventListener('drop', function(e) {
        e.preventDefault();
        zone.style.borderColor = '#ccc';
        if (e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            filename.textContent = 'Archivo: ' + e.dataTransfer.files[0].name;
        }
    });

    input.addEventListener('change', function() {
        if (input.files.length > 0) {
            filename.textContent = 'Archivo: ' + input.files[0].name;
        }
    });
});
</script>
@endpush
