$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    function toggleAlmacen() {
        var consolidado = $('#consolidado-select').val();
        if (consolidado === 'si') {
            $('#div-almacen').hide();
            $('select[name="almacen_id"]').val('');
        } else {
            $('#div-almacen').show();
        }
    }

    toggleAlmacen();

    $('#btn-sincronizar-poa').on('click', function() {
        var btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i>');
        btn.prop('disabled', true);
        
        $.ajax({
            url: window.POA_Routes.sync,
            method: 'POST',
            data: {
                anio: $('input[name="anio"]').val() || new Date().getFullYear(),
                almacen_id: $('select[name="almacen_id"]').val() || '',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.message || 'Sincronización completada');
                cargarTablaPOA();
            },
            error: function(xhr) {
                alert('Error al sincronizar: ' + (xhr.responseJSON?.message || 'Error desconocido'));
            },
            complete: function() {
                btn.html('<i class="fas fa-sync-alt"></i> Sincronizar');
                btn.prop('disabled', false);
            }
        });
    });

    $('#consolidado-select').on('change', function() {
        toggleAlmacen();
        cargarTablaPOA();
    });

    $('#periodo-select').on('change', function() {
        var periodo = $(this).val();
        $('#div-mes').hide();
        $('#div-trimestre').hide();
        if (periodo === 'mensual') {
            $('#div-mes').show();
        } else if (periodo === 'trimestral') {
            $('#div-trimestre').show();
        }
        cargarTablaPOA();
    });

    $('#filtro-poa-form').on('change', 'select[name="mes"], select[name="anio"], select[name="almacen_id"], select[name="trimestre"]', function() {
        cargarTablaPOA();
    });

    var cargandoTabla = false;
    window.cargarTablaPOA = function() {
        if (cargandoTabla) return;
        cargandoTabla = true;
        
        var url = $('#filtro-poa-form').attr('action');
        var data = $('#filtro-poa-form').serialize();

        var btn = $('#filtro-poa-form').find('button[type="submit"]');
        btn.html('<i class="fas fa-spinner fa-spin"></i>');
        btn.prop('disabled', true);

        $.ajax({
            url: url,
            data: data,
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#contenedor-tabla-poa').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', status, error);
                alert('Error al filtrar los datos del POA.');
            },
            complete: function() {
                btn.html('<i class="fas fa-search"></i>');
                btn.prop('disabled', false);
                cargandoTabla = false;
            }
        });
    };

    $('#btn-limpiar-poa').on('click', function() {
        $('select[name="consolidado"]').val('si');
        $('select[name="almacen_id"]').val('');
        $('input[name="anio"]').val(new Date().getFullYear());
        $('select[name="periodo"]').val('mensual');
        $('select[name="trimestre"]').val(Math.ceil((new Date().getMonth() + 1) / 3));
        $('select[name="mes"]').val(new Date().getMonth() + 1);
        toggleAlmacen();
        $('#div-mes').show();
        $('#div-trimestre').hide();
        cargarTablaPOA();
    });

    $('#filtro-poa-form button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        cargarTablaPOA();
    });
});