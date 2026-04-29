@props(['action' => '', 'method' => 'POST'])

<div class="card import-card">
    <div class="card-header bg-institucional-verde text-white">
        <h3 class="card-title"><i class="fas fa-chart-line"></i> Importar Presupuesto (Estado de Resultados)</h3>
    </div>
    <div class="card-body">
        <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año fiscal</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
                <small class="text-muted">Año del cual quieres importar los datos</small>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <div class="drop-zone" id="drop-zone-er">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic para seleccionar</p>
                    <small class="text-muted">Formatos: .xlsx, .xls, .csv</small>
                    <input type="file" name="archivo" id="archivo-er" accept=".xlsx,.xls,.csv" style="display:none" required>
                </div>
                <div id="filename-er" class="mt-2 text-muted small"></div>
            </div>
            <button type="submit" class="btn btn-success btn-import btn-block">
                <i class="fas fa-process"></i> Procesar Estado de Resultados
            </button>
        </form>
    </div>
</div>