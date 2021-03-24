<div class="modal fade" id="modal-materia-prima-mostrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-materia-prima-mostrar-title">Mostrar Materia Prima</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-materia-prima-mostrar-body">
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Nombre</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid' : errores.nombre }" placeholder="Ingrese Nombre"
                            v-model="materiaPrima.nombre" readonly/>
                        <small class="text-danger font-weight-bold" v-for="error in errores.nombre">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Descripci&oacute;n</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Nombre"
                            v-model="materiaPrima.descripcion" readonly/>
                        <small class="text-danger font-weight-bold" v-for="error in errores.descripcion">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>