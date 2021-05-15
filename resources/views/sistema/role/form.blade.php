<div class="modal fade" id="modal-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-role-title">Nuevo Rol</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-role-body">
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Nombre</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Rol"
                            v-model="role.name" :class="{'is-invalid': errores.name }"  
                            :readonly="role.estadoCrud=='mostrar'"/>
                        <small class="text-danger" v-for="error in errores.name">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-guardar-role" :value='role.estadoCrud'
                            name="btn-guardar-role" @click.prevent="guardarRole"
                        v-if="role.estadoCrud!='mostrar'">
                            <i :class="(role.estadoCrud == 'nuevo') ? 'fa fa-save' : 'fa fa-refresh'"></i>  
                        @{{ ( role.estadoCrud == 'nuevo' ? 'Guardar' : 'Actualizar')}}
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