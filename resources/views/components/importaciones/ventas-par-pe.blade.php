@props(['almacenes' => []])

<div class="card import-card import-card-azul">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-cash-register"></i> Importar Ventas por Línea (PAR/PE)</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('importaciones.ventas') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="alert alert-indigo small mb-3">
                <i class="fas fa-magic"></i>
                El sistema detectará automáticamente los datos de <strong>PAR</strong> y <strong>Ventas Especiales (ESP)</strong> dentro del mismo archivo.
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <label for="archivo-ventas" class="upload-area upload-area-azul" id="zone-upload-ventas" style="display: block;">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo de ventas o haz clic</p>
                    <small class="text-muted">Formatos: .xlsx, .xls, .csv</small>
                </label>
                <input type="file" name="archivo" id="archivo-ventas" accept=".xlsx,.xls,.csv" style="display:none" required>
                <div id="filename-ventas" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-info small mt-3">
                <i class="fas fa-info-circle"></i>
                El almacén, año y mes se detectan automáticamente. Los datos se sincronizan directamente al "Realizado" del POA.
            </div>
            <button type="submit" class="btn btn-primary btn-import btn-block">
                <i class="fas fa-upload"></i> Procesar Ventas
            </button>
        </form>
    </div>
</div>