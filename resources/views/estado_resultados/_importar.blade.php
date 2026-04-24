<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Carga Masiva (Excel)</h3>
    </div>
    <form action="{{ route('estado-resultados.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="anio">Año de los datos:</label>
                <input type="number" name="anio" id="anio" class="form-control" value="{{ date('Y') }}" required>
            </div>
            <div class="form-group">
                <label for="archivo_excel">Archivo Excel:</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="archivo_excel" name="archivo_excel" accept=".xlsx, .xls, .csv" required>
                        <label class="custom-file-label" for="archivo_excel">Elegir archivo...</label>
                    </div>
                </div>
                <small class="form-text text-muted">Asegúrate de que la Unidad Operativa esté en la fila 4 y el Almacén en la 5. Los datos inician después de la fila 12.</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Importar Datos</button>
        </div>
    </form>
</div>
