<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Roles&nbsp;
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevoRole">
                <i class="fas fa-plus"></i> Nuevo Rol
            </button>
        </h3>
    </div>
    <div class="card-body" id="listado-roles">
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="pagina_usuario" @change="cambiarPaginacionRole" >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    &nbsp;
                    <input type="text" name="table-search" id="table-search"
                        class="form-control"  placeholder="Buscar..." v-model="buscar_role"
                        @change="buscarRole">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1" id="detalle-tabla">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover text-nowrap">
                        <thead class="bg-navy">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Guard Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_roles==0">
                                <td class="text-center text-danger" colspan="7">-- Datos No Registrados --</td>
                            </tr>
                            <tr v-else v-for="(role,fila) in roles.data">
                                <td class="text-center">@{{ roles.from + fila }}</td>
                                <td v-text="role.name"></td>
                                <td v-text="role.guard_name"></td>
                                <td>
                                    <button type="button" class="btn bg-info btn-xs"
                                            title="Mostrar Role" @click="mostrarRole(role.id)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs"
                                            title="Editar Role" @click="editarRole(role.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs"
                                            title="Eliminar Role" @click="eliminarRole(role.id)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('sistema.role.form')