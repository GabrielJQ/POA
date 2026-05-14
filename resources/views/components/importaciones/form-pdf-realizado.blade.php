<div class="card import-card import-card-indigo">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-file-pdf"></i> Ejecución Real (PDF)</h3>
        <span class="badge bg-white text-secondary font-weight-bold" style="font-size:0.7rem;">REALIZADO (Conc. 4 y 5)</span>
    </div>
    <div class="card-body d-flex flex-column">
        <form action="{{ route('importaciones.pdf-realizado') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-fill">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año de ejecución</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo PDF</label>
                <label for="archivo-pdf" class="upload-area upload-area-indigo" id="zone-upload-pdf" style="display: block;">
                    <i class="fas fa-file-pdf fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic aquí</p>
                    <small class="text-muted">Formato: PDF (.pdf)</small>
                </label>
                <input type="file" name="archivo" id="archivo-pdf" accept=".pdf" style="display:none" required>
                <div id="filename-pdf" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-guinda small mt-1">
                <i class="fas fa-file-pdf"></i>
                Extrae automáticamente los montos de <strong>Resultado Directo de Operación</strong> y <strong>Gastos de Distribución</strong> del PDF. Alimenta el <strong>REALIZADO</strong> de los conceptos 4 y 5.
            </div>
            <button type="submit" class="btn btn-oro btn-import btn-block mt-auto">
                <i class="fas fa-upload"></i> Importar
            </button>
        </form>
    </div>
</div>
