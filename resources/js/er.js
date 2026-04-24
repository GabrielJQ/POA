$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    $('#filtro-form').on('submit', function(e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let data = $(this).serialize();
        
        let btn = $(this).find('button[type="submit"]');
        let originalText = btn.html();
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
            }
        });
    });

    $('#btn-limpiar').on('click', function() {
        $('select[name="almacen_id"]').val('');
        $('input[name="anio"]').val(new Date().getFullYear());
        $('#filtro-form').submit();
    });

    $('#btn-exportar').on('click', function(e) {
        e.preventDefault();
        let url = window.ER_Routes.export + '?' + $('#filtro-form').serialize();
        window.location.href = url;
    });
});