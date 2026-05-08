<x-poa.tabla
    :compromisos="$compromisos"
    :data-poa="$dataPoa"
    :config="$config"
    :label-periodo="$labelPeriodo"
    :anio-seleccionado="$anioSeleccionado ?? date('Y')"
    :almacen-seleccionado="$almacenSeleccionado ?? null"
    :mostrar-consolidado="$mostrarConsolidado ?? true"
/>
