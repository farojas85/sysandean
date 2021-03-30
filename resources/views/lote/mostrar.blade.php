<div class="modal fade" id="modal-lote-mostrar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-lote-mostrar-title">Mostrar Lote</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-lote-mostrar-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Nombre</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" 
                                            v-model="lote.nombre" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Materia Prima</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm"
                                            v-model="lote.materia_prima_nombre" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Kilogramo</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.kilogramo" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Descripci&oacute;n</label>
                                    <div class="col-md-8 ">
                                        <textarea rows="2" class="form-control form-control-sm"
                                            v-model="lote.descripcion" disabled  style="resize: none"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Fecha Registro</label>
                                    <div class="col-md-8 ">
                                        <input type="date" class="form-control form-control-sm"
                                            v-model="lote.fecha_registro" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-success">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Maduras</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.maduros" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Pinton</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.pinton" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Verde</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.verde" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Podridos</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.podrido" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Peque&ntilde;as</label>
                                    <div class="col-md-8 ">
                                        <input type="number" class="form-control form-control-sm"
                                            v-model="lote.enanas" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
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