<div class="card import-card import-card-teal">
    <div class="card-header bg-teal text-white">
        <h3 class="card-title"><i class="fas fa-percentage"></i> Surtimiento a Tiendas (Real)</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('importaciones.surtimiento') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel (CONS {{ date('Y') }}.xlsx)</label>
                <label for="archivo-surtimiento" class="upload-area upload-area-teal" id="zone-upload-surt" style="display: block;">
                    <i class="fas fa-file-excel fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic aquí</p>
                    <small class="text-muted">CONS 2026.xlsx — Oportunidad y Eficiencia de Surtimiento</small>
                </label>
                <input type="file" name="archivo" id="archivo-surtimiento" accept=".xlsx,.xls" style="display:none" required>
                <div id="filename-surt" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-info small mt-3">
                <i class="fas fa-magic"></i>
                El sistema leerá todos los trimestres con datos del archivo y distribuirá el valor trimestral en partes iguales entre los 3 meses correspondientes.
            </div>
            <button type="submit" class="btn btn-teal btn-import btn-block">
                <i class="fas fa-bolt"></i> Importar Surtimiento
            </button>
        </form>
    </div>
</div>
