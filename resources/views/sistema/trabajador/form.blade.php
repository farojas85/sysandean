<div class="modal fade" id="modal-trabajador">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-trabajador-title">Nuevo Trabajador</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-trabajador-body">
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Documento Identidad</label>
                    <div class="col-md-8 mb-2">
                        <select v-model="trabajador.tipo_documento_id" class="form-control form-control-sm">
                            <option value="">-Seleccionar-</option>
                            <option v-for="tipo in tipoDocumentosLista" :key='tipo.id' :value="tipo.id" v-text="tipo.nombre_corto"></option>
                        </select>
                        <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>N&uacute;mero Documento</label>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Número Documento de Identidad"
                            v-model="trabajador.numero_documento" maxlength="15" @keyUp="validarDocumento" />
                        <small class="text-danger" v-for="error in errores.numero_documento">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Nombres</label>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Nombres"
                            v-model="trabajador.nombres"/>
                        <small class="text-danger" v-for="error in errores.nombres">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Apellidos</label>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Apellidos"
                            v-model="trabajador.apellidos"/>
                        <small class="text-danger" v-for="error in errores.apellidos">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Fecha Nacimiento</label>
                    <div class="col-md-8 mb-2">
                        <input type="date" class="form-control form-control-sm" placeholder="Ingrese Fecha de Nacimiento"
                            v-model="trabajador.fecha_nacimiento"/>
                        <small class="text-danger" v-for="error in errores.fecha_nacimiento">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Lugar Nacimiento</label>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Lugar Nacimiento"
                            v-model="trabajador.lugar_nacimiento"/>
                        <small class="text-danger" v-for="error in errores.lugar_nacimiento">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-4 mb-1 col-form-label col-form-label-sm'>Estado</label>
                    <div class="col-md-8 mb-2">
                        <input type="checkbox" v-model="trabajador.estado" />
                        @{{ trabajador.estado ? 'Activo' : 'Inactivo'}}
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-guardar-usuario" :value='trabajador.estadoCrud'
                            name="btn-guardar-trabajador" @click.prevent="guardarTrabajador">
                            <i :class="(trabajador.estadoCrud == 'nuevo') ? 'fas fa-save' : 'fas fa-sync'"></i>  
                        @{{ ( trabajador.estadoCrud == 'nuevo' ? 'Guardar' : 'Actualizar')}}
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