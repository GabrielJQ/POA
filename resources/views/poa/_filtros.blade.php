<form id="filtro-poa-form" method="GET" action="{{ route('poa.index') }}" class="mb-3 px-2" onsubmit="return false;">
    <div class="row align-items-end">
        <div class="col-md-2">
            <label class="small font-weight-bold">Consolidado</label>
            <select name="consolidado" class="form-control form-control-sm" id="consolidado-select">
                <option value="si" {{ $mostrarConsolidado === true ? 'selected' : '' }}>Todos los Almacenes</option>
                <option value="no" {{ $mostrarConsolidado === false ? 'selected' : '' }}>Individual</option>
            </select>
        </div>
        <div class="col-md-2" id="div-almacen">
            <label class="small font-weight-bold">Almacén</label>
            <select name="almacen_id" class="form-control form-control-sm">
                <option value="">Seleccionar...</option>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="small font-weight-bold">Año</label>
            <input type="number" name="anio" class="form-control form-control-sm" value="{{ $anioSeleccionado }}">
        </div>
        <div class="col-md-2">
            <label class="small font-weight-bold">Período</label>
            <select name="periodo" class="form-control form-control-sm" id="periodo-select">
                <option value="mensual" {{ $periodoTipo === 'mensual' ? 'selected' : '' }}>Mensual</option>
                <option value="trimestral" {{ $periodoTipo === 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                <option value="anual" {{ $periodoTipo === 'anual' ? 'selected' : '' }}>Anual</option>
            </select>
        </div>
        <div class="col-md-2" id="div-trimestre" style="display: {{ $periodoTipo === 'trimestral' ? 'block' : 'none' }}">
            <label class="small font-weight-bold">Trimestre</label>
            <select name="trimestre" class="form-control form-control-sm">
                @foreach($trimestres as $num => $nombre)
                    <option value="{{ $num }}" {{ $trimestreSeleccionado == $num ? 'selected' : '' }}>{{ $num }}: {{ $nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2" id="div-mes" style="display: {{ $periodoTipo === 'mensual' ? 'block' : 'none' }}">
            <label class="small font-weight-bold">Mes</label>
            <select name="mes" class="form-control form-control-sm">
                @foreach($meses as $numMes => $nombreMes)
                    <option value="{{ $numMes }}" {{ $mesActual == $numMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 text-right">
            <button type="submit" class="btn btn-info btn-sm mr-1" title="Filtrar">
                <i class="fas fa-search"></i>
            </button>
            <button type="button" id="btn-limpiar-poa" class="btn btn-secondary btn-sm" title="Limpiar Filtros">
                <i class="fas fa-eraser"></i>
            </button>
        </div>
    </div>
</form>