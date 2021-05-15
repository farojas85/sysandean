<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Permisos /Roles
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info py-2 text-white">
                        <h5 class="card-title mb-0 text-white">ROLES / MODELOS</h5>
                    </div>                    
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Rol:</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model='permiso_role.role_id'> 
                                    <option value="">-SELECCIONAR-</option>
                                    <option v-for="rol in rolesLista" :key='rol.id' :value="rol.id">
                                        @{{rol.name}}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in errores.role_id">@{{ error }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Modelo:</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="permiso_role.modelo"  @change="mostrarRolePermisos">
                                    <option value="">-SELECCIONAR-</option>
                                    <option v-for="modelo in modelos" :key='modelo.name' :value="modelo.name">
                                        @{{ modelo.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-maroon py-2 text-white">
                        <h5 class="card-title mb-0 text-white" >PERMISOS PARA: ...<span v-if="permiso_role.role_name">@{{ permiso_role.role_name }}</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-success" v-if="permisos_select.length==0">
                            <h5 class="text-primary">Seleccione Rol y Modelo para mostrar Datos Aqu&iacute;</h5>
          
                            <p>This is a green callout.</p>
                        </div>
                        <div class="tab-content pt-0" id="tab-contenido" v-else>
                            <div v-for="permiso in permisos_select" :key="permiso.id">
                                <label>
                                    <input type="checkbox" v-model="permiso_role.permission_name" :value="permiso.name">
                                    @{{ permiso.name }}
                                </label>
                            </div>
                            <div class="row container-fluid text-center" v-if="permiso_role.modelo">
                                <button type="button" class="btn btn-success" @click="guardarRolePermiso">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>