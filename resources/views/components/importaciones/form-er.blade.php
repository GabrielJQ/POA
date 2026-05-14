@props(['action' => '', 'method' => 'POST'])

<div class="card import-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-chart-line"></i> Estado de Resultados</h3>
        <span class="badge bg-white text-secondary font-weight-bold" style="font-size:0.7rem;">COMPROMETIDO (Conc. 1 al 5)</span>
    </div>
    <div class="card-body d-flex flex-column">
        <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data" class="d-flex flex-column flex-fill">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Año fiscal</label>
                <input type="number" name="anio" class="form-control" value="{{ date('Y') }}" min="2000" max="2100" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <label for="archivo-er" class="upload-area" id="zone-upload-er" style="display: block;">
                    <i class="fas fa-file-excel fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic para seleccionar</p>
                    <small class="text-muted">Formatos: Excel (.xlsx, .xls, .csv)</small>
                </label>
                <input type="file" name="archivo" id="archivo-er" accept=".xlsx,.xls,.csv" style="display:none" required>
                <div id="filename-er" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-guinda small mt-1">
                <i class="fas fa-chart-line"></i>
                Importa el presupuesto desde el Excel de Estado de Resultados. Alimenta el <strong>COMPROMETIDO</strong> de los conceptos 1 al 5 del POA.
            </div>
            <button type="submit" class="btn btn-oro btn-import btn-block mt-auto">
                <i class="fas fa-upload"></i> Importar
            </button>
        </form>
    </div>
</div>