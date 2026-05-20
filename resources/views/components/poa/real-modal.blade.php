<div class="modal fade" id="modalEditarReal" tabindex="-1" role="dialog" aria-labelledby="modalEditarRealLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-institucional-verde text-white">
                <h5 class="modal-title" id="modalEditarRealLabel">
                    <i class="fas fa-edit mr-2"></i>Editar Real — <span id="realConceptoNombre"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tienda:</strong> <span id="realAlmacenNombre" class="text-muted"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>Año:</strong> <span id="realAnio" class="text-muted"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>Período:</strong> <span id="realPeriodoLabel" class="text-muted"></span>
                    </div>
                </div>

                <div id="realVentasInfo" class="alert alert-info d-none">
                    <i class="fas fa-info-circle mr-1"></i>
                    Los datos de VENTAS provienen de importación ER. Los REALES manuales se sumarán a los importados.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm real-meses-table">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Mes</th>
                                <th>Valor REAL</th>
                            </tr>
                        </thead>
                        <tbody id="realMesesBody">
                        </tbody>
                    </table>
                </div>

                <div id="realGuardarFeedback" class="alert d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="realGuardarBtn" disabled>
                    <i class="fas fa-save mr-1"></i>Guardar Reales
                </button>
            </div>
        </div>
    </div>
</div>
