<div class="card import-card import-card-orange">
    <div class="card-header bg-orange text-white">
        <h3 class="card-title"><i class="fas fa-weight-hanging"></i> Mermas, Quebrantos y Mal Estado</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('importaciones.mermas') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo PT FORMATO</label>
                <label for="archivo-mermas" class="upload-area upload-area-orange" id="zone-upload-mermas" style="display: block;">
                    <i class="fas fa-file-excel fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic aquí</p>
                    <small class="text-muted">PT FORMATO 02 2026 (VENTAS X LINEA)_CONSOLIDADO.XLSX</small>
                </label>
                <input type="file" name="archivo" id="archivo-mermas" accept=".xlsx,.xls" style="display:none" required>
                <div id="filename-mermas" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-info small mt-3">
                <i class="fas fa-calculator"></i>
                El sistema leerá las ventas por línea del PROGRAMA ABASTO RURAL y aplicará los porcentajes de merma y quebranto configurados para calcular el COMPROMETIDO mensual por almacén.
            </div>
            <button type="submit" class="btn btn-orange btn-import btn-block">
                <i class="fas fa-bolt"></i> Importar Mermas
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
