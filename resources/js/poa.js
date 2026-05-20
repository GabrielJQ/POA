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

    $('#filtro-poa-form').on('change', '[name="anio"], [name="mes"], [name="almacen_id"], [name="trimestre"]', function() {
        recargarTodo();
    });

    var cargandoTabla = false;
    var pendienteRecarga = false;
    window.cargarTablaPOA = function() {
        if (cargandoTabla) {
            pendienteRecarga = true;
            return;
        }
        cargandoTabla = true;
        pendienteRecarga = false;
        
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
                if (pendienteRecarga) {
                    recargarTodo();
                }
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

    /* ---- Modal Editar Real ---- */
    var realDataCache = {};

    function getAlmacenNombre(id) {
        if (typeof ALMACENES !== 'undefined') {
            var found = ALMACENES.find(function(a) { return a.id === id; });
            return found ? found.nombre : id;
        }
        return id;
    }

    $(document).on('click', '.real-btn-edit', function() {
        var $btn = $(this);
        var conceptoId = $btn.data('concepto-id');
        var conceptoNombre = $btn.data('concepto-nombre');
        var almacenId = $btn.data('almacen-id');
        var anio = $btn.data('anio');
        var esVentas = $btn.data('es-ventas') === 'true';
        var esPorcentaje = $btn.data('es-porcentaje') === 'true';
        var mesesActivos = $btn.data('meses-activos');

        if (typeof mesesActivos === 'string') {
            try { mesesActivos = JSON.parse(mesesActivos); } catch(e) { mesesActivos = null; }
        }
        if (!Array.isArray(mesesActivos) || mesesActivos.length === 0) {
            var periodoLabel = $('#periodo-select').val() || 'mensual';
            if (periodoLabel === 'anual') {
                mesesActivos = [1,2,3,4,5,6,7,8,9,10,11,12];
            } else {
                var mesSel = parseInt($('select[name="mes"]').val()) || new Date().getMonth() + 1;
                mesesActivos = [mesSel];
            }
        }

        var NOMBRES_MESES = {1:'ENERO',2:'FEBRERO',3:'MARZO',4:'ABRIL',5:'MAYO',6:'JUNIO',7:'JULIO',8:'AGOSTO',9:'SEPTIEMBRE',10:'OCTUBRE',11:'NOVIEMBRE',12:'DICIEMBRE'};
        var NOMBRES_TRIMESTRES = {1:'ENE-MAR',2:'ABR-JUN',3:'JUL-SEP',4:'OCT-DIC'};
        var periodo = $('#periodo-select').val() || 'mensual';
        var periodoLabel;
        if (periodo === 'anual') {
            periodoLabel = 'ANUAL';
        } else if (periodo === 'trimestral') {
            var t = parseInt($('select[name="trimestre"]').val()) || 1;
            periodoLabel = 'T' + t + ' ' + (NOMBRES_TRIMESTRES[t] || '');
        } else {
            var m = parseInt($('select[name="mes"]').val()) || new Date().getMonth() + 1;
            periodoLabel = NOMBRES_MESES[m] || ('MES ' + m);
        }

        $('#realConceptoNombre').text(conceptoNombre);
        $('#realAlmacenNombre').text(getAlmacenNombre(almacenId));
        $('#realAnio').text(anio);
        $('#realPeriodoLabel').text(periodoLabel);

        if (esVentas) {
            $('#realVentasInfo').removeClass('d-none');
        } else {
            $('#realVentasInfo').addClass('d-none');
        }

        $('#realMesesBody').html(
            '<tr><td colspan="2" class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>'
        );
        $('#realGuardarFeedback').addClass('d-none');
        $('#realGuardarBtn').prop('disabled', true);

        $('#modalEditarReal').modal('show');

        $.ajax({
            url: '/poa/reales',
            data: {
                concepto_id: conceptoId,
                almacen_id: almacenId,
                anio: anio
            },
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                realDataCache = {
                    concepto_id: conceptoId,
                    almacen_id: almacenId,
                    anio: anio,
                    meses: data.meses,
                    meses_activos: mesesActivos
                };
                renderRealMeses(data.meses, esPorcentaje, mesesActivos);
            },
            error: function() {
                $('#realMesesBody').html(
                    '<tr><td colspan="2" class="text-center py-3 text-danger"><i class="fas fa-exclamation-triangle mr-1"></i>Error al cargar datos</td></tr>'
                );
            }
        });
    });

    function renderRealMeses(meses, esPorcentaje, mesesActivos) {
        var html = '';
        var step = esPorcentaje ? '0.01' : 'any';
        var total = 0;
        var activoSet = {};
        $.each(mesesActivos, function(i, m) { activoSet[m] = true; });

        var mesesFiltrados = meses.filter(function(m) { return activoSet[m.mes]; });

        $.each(mesesFiltrados, function(i, mes) {
            total += mes.monto;
            var formatted = mes.monto.toLocaleString('es-MX', {
                minimumFractionDigits: esPorcentaje ? 2 : 0,
                maximumFractionDigits: 2
            });

            if (mes.existe) {
                html += '<tr class="real-row-locked">' +
                    '<td class="font-weight-bold">' + mes.nombre + '</td>' +
                    '<td class="real-locked-value">' +
                    '<span class="real-locked-badge"><i class="fas fa-lock mr-1"></i>' + formatted + '</span>' +
                    '<input type="hidden" class="real-input-hidden" data-mes="' + mes.mes + '" value="' + mes.monto + '">' +
                    '</td></tr>';
            } else {
                html += '<tr class="real-row-editable">' +
                    '<td class="font-weight-bold">' + mes.nombre + '</td>' +
                    '<td>' +
                    '<input type="number" step="' + step + '" class="form-control form-control-sm real-input" ' +
                    'data-mes="' + mes.mes + '" data-original="' + mes.monto + '" value="' + mes.monto + '" ' +
                    'placeholder="' + (esPorcentaje ? '0.00' : '0') + '">' +
                    '</td></tr>';
            }
        });

        html += '<tr class="real-row-total font-weight-bold">' +
            '<td>Total Período</td>' +
            '<td id="realTotalAnual">' + total.toLocaleString('es-MX', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + '</td></tr>';

        $('#realMesesBody').html(html);
        $('#realGuardarBtn').prop('disabled', true);

        $('.real-input').on('input', function() {
            actualizarBotonGuardar();
            calcularTotalAnual(esPorcentaje);
        });
    }

    function actualizarBotonGuardar() {
        var hayCambios = false;
        $('.real-input').each(function() {
            var original = parseFloat($(this).data('original')) || 0;
            var actual = parseFloat($(this).val()) || 0;
            if (Math.abs(actual - original) > 0.001) {
                hayCambios = true;
                return false;
            }
        });
        $('#realGuardarBtn').prop('disabled', !hayCambios);
    }

    function calcularTotalAnual(esPorcentaje) {
        var total = 0;
        $('.real-input').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('.real-locked-value').each(function() {
            var val = parseFloat($(this).find('.real-input-hidden').val()) || 0;
            total += val;
        });
        $('#realTotalAnual').text(total.toLocaleString('es-MX', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    $(document).on('click', '#realGuardarBtn', function() {
        var $btn = $(this);
        var valores = [];

        $('.real-input').each(function() {
            var original = parseFloat($(this).data('original')) || 0;
            var actual = parseFloat($(this).val()) || 0;
            if (Math.abs(actual - original) > 0.001) {
                valores.push({
                    mes: parseInt($(this).data('mes')),
                    monto: actual
                });
            }
        });

        if (valores.length === 0) {
            return;
        }

        $btn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Guardando...');
        $btn.prop('disabled', true);

        $.ajax({
            url: '/poa/reales/guardar',
            type: 'POST',
            data: {
                concepto_id: realDataCache.concepto_id,
                almacen_id: realDataCache.almacen_id,
                anio: realDataCache.anio,
                valores: valores,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var msg = response.saved + ' valor(es) guardado(s) correctamente.';
                    if (response.errors && response.errors.length > 0) {
                        msg += ' ' + response.errors.join(' ');
                    }
                    mostrarFeedback(msg, 'success');
                    $('#modalEditarReal').modal('hide');
                    cargarTablaPOA();
                } else {
                    var errorMsg = 'Error al guardar algunos valores:<br>';
                    if (response.errors) {
                        errorMsg += response.errors.join('<br>');
                    }
                    mostrarFeedback(errorMsg, 'danger');
                }
            },
            error: function(xhr) {
                var msg = 'Error al guardar los datos.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg += '<br>' + xhr.responseJSON.errors.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    msg += '<br>' + xhr.responseJSON.error;
                }
                mostrarFeedback(msg, 'danger');
            },
            complete: function() {
                $btn.html('<i class="fas fa-save mr-1"></i>Guardar Reales');
                $btn.prop('disabled', false);
            }
        });
    });

    function mostrarFeedback(msg, tipo) {
        var $fb = $('#realGuardarFeedback');
        $fb.removeClass('d-none alert-success alert-danger').addClass('alert-' + tipo).html(msg);
    }

    $(document).on('hidden.bs.modal', '#modalEditarReal', function() {
        realDataCache = {};
    });
});