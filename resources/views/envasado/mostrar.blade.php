<div class="modal fade" id="modal-envasado-mostrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-envasado-title">Mostrar Envasado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-envasado-body">
                <div class="form-group row">
                    <label for="" class='col-md-1 col-form-label col-form-label-sm'>Lote</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" placeholder="Buscar Lote"
                            v-model="envasado.lote_nombre"  readonly/>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-xs">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                          </div>
                        <small class="text-danger font-weight-bold" v-for="error in errores.lote_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Kg. envasado</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Kilogramos envasados"
                            v-model="envasado.kilogramo_envasado" :class="{ 'is-invalid' : errores.kilogramo_envasado }"  readonly/>
                        <small class="text-danger font-weight-bold" v-for="error in errores.kilogramo_envasado">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm' title="Fecha Registro">Fecha Registro</label>
                    <div class="col-md-8 ">
                        <input type="date" class="form-control form-control-sm" placeholder="Seleccione Fecha" readonly
                            v-model="envasado.fecha_registro" :class="{ 'is-invalid' : errores.fecha_registro }"/>
                        <small class="text-danger font-weight-bold" v-for="error in errores.fecha_registro">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm' title="Fecha Registro">Trabajador</label>
                    <div class="col-md-8 ">
                        <select v-model="envasado.trabajador_id" class="form-control form-control-sm" disabled >
                            <option value="">-Seleccionar-</option>
                            <option v-for="t in trabajadores" :key="t.id" :value="t.id" v-text="t.nombres"></option>
                        </select>
                        <small class="text-danger font-weight-bold" v-for="error in errores.trabajador_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Observaciones</label>
                    <div class="col-md-8 ">
                        <textarea rows="2" class="form-control form-control-sm" placeholder="Ingrese Obseraci??n"
                            v-model="envasado.observacion"  readonly></textarea>
                        <small class="text-danger font-weight-bold" v-for="error in errores.observacion">@{{ error }}</small>
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
</div>