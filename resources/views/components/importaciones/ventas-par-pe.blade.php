@props(['almacenes' => []])

<div class="card import-card import-card-azul">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-cash-register"></i> Ventas por Línea</h3>
        <span class="badge bg-white text-secondary font-weight-bold" style="font-size:0.7rem;">REALIZADO (Conc. 1 al 3)</span>
    </div>
    <div class="card-body d-flex flex-column">
        <form action="{{ route('importaciones.ventas') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-fill">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <label for="archivo-ventas" class="upload-area upload-area-azul" id="zone-upload-ventas" style="display: block;">
                    <i class="fas fa-file-excel fa-2x text-muted mb-2"></i>
                    <p class="mb-1">Arrastra el archivo o haz clic aquí</p>
                    <small class="text-muted">Formatos: Excel (.xlsx, .xls, .csv)</small>
                </label>
                <input type="file" name="archivo" id="archivo-ventas" accept=".xlsx,.xls,.csv" style="display:none" required>
                <div id="filename-ventas" class="mt-2 text-muted small"></div>
            </div>
            <div class="alert alert-guinda small mt-1">
                <i class="fas fa-cash-register"></i>
                Importa las ventas del programa <strong>ABASTO RURAL (PAR)</strong> y <strong>Programas Especiales (PE)</strong>. Alimenta el <strong>REALIZADO</strong> de los conceptos 1 al 3.
            </div>
            <button type="submit" class="btn btn-oro btn-import btn-block mt-auto">
                <i class="fas fa-upload"></i> Importar
            </button>
        </form>
    </div>
</div>