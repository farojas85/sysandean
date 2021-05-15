<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Roles&nbsp;
            @can('roles.crear')
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevoRole">
                <i class="fas fa-plus"></i> Nuevo Rol
            </button>
            @endcan
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
                                    @can('roles.mostrar')
                                    <button type="button" class="btn bg-info btn-xs"
                                            title="Mostrar Role" @click="mostrarRole(role.id)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @endcan
                                    @can('roles.editar')
                                    <button type="button" class="btn btn-warning btn-xs"
                                            title="Editar Role" @click="editarRole(role.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endcan
                                    @can('roles.eliminar')
                                    <button type="button" class="btn btn-danger btn-xs"
                                            title="Eliminar Role" @click="eliminarRole(role.id)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <ul class="pagination">
                        <li v-if="roles.current_page >=2" class="page-item">
                            <a href="" aria-label="First" class="page-link"
                            @click.prevent="changePageRoles(0)">
                                <span><i class="fas fa-fast-backward"></i></span>
                            </a>
                        </li>
                        <li v-if="roles.current_page > 1" class="page-item">
                            <a href="" aria-label="Previous" class="page-link"
                            @click.prevent="changePageRoles(roles.current_page - 1)">
                                <span><i class="fas fa-backward"></i></span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumberRole" class="page-item"
                            v-bind:class="[ page == isActivedRole ? 'active' : '']">
                            <a href="" class="page-link"
                                @click.prevent="changePageRoles(page)">@{{ page }}</a>
                        </li>
                        <li v-if="roles.current_page < roles.last_page" class="page-item">
                            <a href="" aria-label="Next" class="page-link"
                                @click.prevent="changePageRoles(roles.current_page + 1)">
                                <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                            </a>
                        </li>
                        <li v-if="roles.current_page < roles.last_page-1" class="page-item">
                            <a href="" aria-label="Last" class="page-link"
                                @click.prevent="changePageRoles(roles.last_page)">
                                <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@include('sistema.role.form')