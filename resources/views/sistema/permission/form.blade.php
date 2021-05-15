<div class="modal fade" id="modal-permiso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-permiso-title">Nuevo Permiso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-permiso-body">
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Nombre</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Permiso"
                            v-model="permiso.name" :class="{'is-invalid': errores.name }"  
                            :readonly="permiso.estadoCrud=='mostrar'"/>
                        <small class="text-danger" v-for="error in errores.name">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-guardar-permiso" :value='permiso.estadoCrud'
                            name="btn-guardar-permiso" @click.prevent="guardarPermiso"
                        v-if="permiso.estadoCrud!='mostrar'">
                            <i :class="(permiso.estadoCrud == 'nuevo') ? 'fa fa-save' : 'fa fa-refresh'"></i>  
                        @{{ ( permiso.estadoCrud == 'nuevo' ? 'Guardar' : 'Actualizar')}}
                    </button> 
                    &nbsp;
                    <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>