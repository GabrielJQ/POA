$(document).ready(function() {
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

    $('.select2').on('select2:select', function() {
        $(this).trigger('change');
    });

    var cargando = false;
    var pendienteRecarga = false;

    function enviarFiltros() {
        if (cargando) {
            pendienteRecarga = true;
            return;
        }
        cargando = true;
        pendienteRecarga = false;

        var url = $('#filtro-form').attr('action');
        var data = $('#filtro-form').serialize();

        var btn = $('#filtro-form').find('button[type="submit"]');
        var originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i>');
        btn.prop('disabled', true);

        $.ajax({
            url: url,
            data: data,
            success: function(response) {
                $('#contenedor-tabla').html(response);
            },
            error: function() {
                alert('Error al filtrar los datos.');
            },
            complete: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
                cargando = false;
                if (pendienteRecarga) {
                    enviarFiltros();
                }
            }
        });
    }

    $('#filtro-form').on('change', '[name="anio"], [name="almacen_id"]', function() {
        enviarFiltros();
    });

    $('#filtro-form').on('submit', function(e) {
        e.preventDefault();
        enviarFiltros();
    });

    $('#btn-limpiar').on('click', function() {
        $('select[name="almacen_id"]').val('');
        $('input[name="anio"]').val(new Date().getFullYear());
        enviarFiltros();
    });

    $('#btn-exportar').on('click', function(e) {
        e.preventDefault();
        let url = window.ER_Routes.export + '?' + $('#filtro-form').serialize();
        window.location.href = url;
    });
});