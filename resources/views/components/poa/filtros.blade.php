@props([
    'almacenes' => [],
    'mostrarConsolidado' => true,
    'almacenSeleccionado' => null,
    'anioSeleccionado' => null,
    'periodoTipo' => 'mensual',
    'trimestreSeleccionado' => 1,
    'mesActual' => null,
    'trimestres' => [],
    'meses' => [],
    'esCapturista' => false
])

<form id="filtro-poa-form" method="GET" action="{{ route('poa.index') }}" class="mb-3 px-2" onsubmit="return false;">
    <div class="row align-items-end">
        @if($esCapturista)
            <div class="col-md-2">
                <label class="poa-filter-label"><i class="fas fa-warehouse mr-1"></i> Almacén</label>
                <input type="text" class="form-control form-control-sm" value="{{ $almacenSeleccionado ? ($almacenes->firstWhere('id', $almacenSeleccionado)->nombre ?? '') : '' }}" readonly>
                <input type="hidden" name="almacen_id" value="{{ $almacenSeleccionado }}">
                <input type="hidden" name="consolidado" value="no">
            </div>
        @else
        <div class="col-md-2">
            <label class="poa-filter-label"><i class="fas fa-layer-group mr-1"></i> Consolidado</label>
            <select name="consolidado" class="form-control form-control-sm select2" id="consolidado-select">
                <option value="si" {{ $mostrarConsolidado === true ? 'selected' : '' }}>Todos los Almacenes</option>
                <option value="no" {{ $mostrarConsolidado === false ? 'selected' : '' }}>Individual</option>
            </select>
        </div>
        <div class="col-md-2" id="div-almacen">
            <label class="poa-filter-label"><i class="fas fa-warehouse mr-1"></i> Almacén</label>
            <select name="almacen_id" class="form-control form-control-sm select2">
                <option value="">Seleccionar...</option>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}" {{ $almacenSeleccionado == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-1">
            <label class="poa-filter-label"><i class="fas fa-calendar-alt mr-1"></i> Año</label>
            <input type="number" name="anio" class="form-control form-control-sm" value="{{ $anioSeleccionado }}">
        </div>
        <div class="col-md-2">
            <label class="poa-filter-label"><i class="fas fa-clock mr-1"></i> Período</label>
            <select name="periodo" class="form-control form-control-sm select2" id="periodo-select">
                <option value="mensual" {{ $periodoTipo === 'mensual' ? 'selected' : '' }}>Mensual</option>
                <option value="trimestral" {{ $periodoTipo === 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                <option value="anual" {{ $periodoTipo === 'anual' ? 'selected' : '' }}>Anual</option>
            </select>
        </div>
        <div class="col-md-2" id="div-trimestre" style="display: {{ $periodoTipo === 'trimestral' ? 'block' : 'none' }}">
            <label class="poa-filter-label"><i class="fas fa-chart-pie mr-1"></i> Trimestre</label>
            <select name="trimestre" class="form-control form-control-sm select2">
                @foreach($trimestres as $num => $nombre)
                    <option value="{{ $num }}" {{ $trimestreSeleccionado == $num ? 'selected' : '' }}>{{ $num }}: {{ $nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2" id="div-mes" style="display: {{ $periodoTipo === 'mensual' ? 'block' : 'none' }}">
            <label class="poa-filter-label"><i class="fas fa-calendar-day mr-1"></i> Mes</label>
            <select name="mes" class="form-control form-control-sm select2">
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