<div class="modal fade" id="modal-pelado-quimico-mostrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-pelado-quimico-mostrar-title">Mostrar Pelado Qu&iacute;mico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-pelado-quimico-mostrar-body">
                <div class="form-group row">
                    <label for="" class='col-md-2 col-form-label col-form-label-sm'>Kilogramos</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm"
                            v-model="peladoQuimico.lote_nombre" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-2 col-form-label col-form-label-sm'>Kilogramos</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm"
                            v-model="peladoQuimico.kilogramo"  readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-2 col-form-label col-form-label-sm'>Observaci&oacute;n</label>
                    <div class="col-md-8 ">
                        <textarea rows="2" class="form-control form-control-sm" 
                            v-model="peladoQuimico.observacion" readonly ></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-2 col-form-label col-form-label-sm' title="Fecha Registro">Fecha Re.</label>
                    <div class="col-md-8 ">
                        <input type="date" class="form-control form-control-sm" placeholder="Seleccione Fecha"
                            v-model="peladoQuimico.fecha_registro" readonly />
                    </div>
                </div>
            </div>
            <div class="modal-footer form-group text-center">
                <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>