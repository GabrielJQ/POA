$(document).ready(function() {
    var exportRoute = typeof RUTA_EXPORT_POA !== 'undefined' ? RUTA_EXPORT_POA : '/poa/export';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // Inicializar Select2
    $('.select2').select2({
        width: '100%',
        dropdownAutoWidth: true,
        placeholder: 'Seleccionar...'
    });

    // Sincronizar cambios de Select2 con los eventos de recarga
    $('.select2').on('select2:select', function() {
        $(this).trigger('change');
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

    $(document).on('blur', '.nota-textarea', function() {
        var $ta = $(this);
        var nota = $ta.val().trim();
        var almacenId = $ta.data('almacen-id');
        $.ajax({
            url: '/poa/nota',
            type: 'POST',
            data: {
                concepto_id: $ta.data('concepto-id'),
                label: $ta.data('label'),
                anio: $ta.data('anio'),
                mes: $ta.data('mes'),
                almacen_id: almacenId || '',
                nota_aclaratoria: nota,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                $ta.css('border-color', '#28a745');
                setTimeout(function() { $ta.css('border-color', ''); }, 1500);
            },
            error: function() {
                $ta.css('border-color', '#dc3545');
            }
        });
    });

    $('#btn-descargar-xlsx, #btn-descargar-pdf').on('click', function(e) {
        e.preventDefault();
        var tipo = $(this).is('#btn-descargar-xlsx') ? 'xlsx' : 'pdf';
        var q = $('#filtro-poa-form').serialize() + '&tipo=' + tipo;
        window.location.href = exportRoute + '?' + q;
    });

    function recargarTodo() {
        cargarTablaPOA();
    }

    $('#consolidado-select').on('change', function() {
        toggleAlmacen();
        recargarTodo();
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
        recargarTodo();
    });

    $('#filtro-poa-form').on('change', 'select[name="mes"], select[name="anio"], select[name="almacen_id"], select[name="trimestre"]', function() {
        recargarTodo();
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
        recargarTodo();
    });

    $('#filtro-poa-form button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        cargarTablaPOA();
    });
});