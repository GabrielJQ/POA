@props([
    'almacenes' => [],
    'almacenSeleccionado' => null,
    'anioSeleccionado' => null
])

<form id="filtro-form" method="GET" action="{{ route('estado-resultados.index') }}" class="mb-4">
    <div class="row align-items-end">
        <div class="col-md-5">
            <label class="poa-filter-label"><i class="fas fa-warehouse mr-1"></i> Almacén</label>
            <select name="almacen_id" class="form-control select2">
                <option value="">Consolidado (Todos los Almacenes)</option>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="poa-filter-label"><i class="fas fa-calendar-alt mr-1"></i> Año</label>
            <input type="number" name="anio" class="form-control" placeholder="Año" value="{{ $anioSeleccionado }}">
        </div>
        <div class="col-md-4 text-right">
            <button type="submit" class="btn btn-info btn-sm mr-1" title="Filtrar">
                <i class="fas fa-search"></i>
            </button>
            <button type="button" id="btn-limpiar" class="btn btn-secondary btn-sm mr-1" title="Limpiar Filtros">
                <i class="fas fa-trash"></i>
            </button>
            <a href="#" id="btn-exportar" class="btn btn-success btn-sm" title="Exportar a Excel">
                <i class="fas fa-file-excel"></i>
            </a>
        </div>
    </div>
</form>