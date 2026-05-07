<div class="card import-card import-card-indigo">
    <div class="card-header bg-indigo text-white">
        <h3 class="card-title"><i class="fas fa-file-pdf"></i> Importar Ejecución Real (PDF)</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('importaciones.pdf-realizado') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año de ejecución</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
                <small class="text-muted">Año al que corresponden los datos del PDF</small>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo PDF</label>
                <label for="archivo-pdf" class="upload-area upload-area-indigo" id="zone-upload-pdf" style="display: block;">
                    <i class="fas fa-file-pdf fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el reporte PDF o haz clic aquí</p>
                    <small class="text-muted">Reporte: Estado de Resultados por Almacén</small>
                </label>
                <input type="file" name="archivo" id="archivo-pdf" accept=".pdf" style="display:none" required>
                <div id="filename-pdf" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-info small mt-3">
                <i class="fas fa-magic"></i>
                El sistema extraerá automáticamente los montos de <strong>TODOS los almacenes</strong> (Oaxaca, Mixes, Ixtlán, Lachixio, Valles Centrales, Matatlán, etc.) para "Total Gastos de Distribución" y "Resultado Directo de Operación".
            </div>
            <button type="submit" class="btn btn-indigo btn-import btn-block">
                <i class="fas fa-bolt"></i> Procesar Reporte PDF
            </button>
        </form>
    </div>
</div>
