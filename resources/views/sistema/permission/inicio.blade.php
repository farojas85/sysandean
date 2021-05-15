<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Permisos&nbsp;
            @can('permisos.crear')
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevoPermiso">
                <i class="fas fa-plus"></i> Nuevo Permiso
            </button>
            @endcan
        </h3>
    </div>
    <div class="card-body" id="listado-permisos">
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="pagina_usuario" @change="cambiarPaginacionPermiso" >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    &nbsp;
                    <input type="text" name="table-search" id="table-search"
                        class="form-control"  placeholder="Buscar..." v-model="buscar_permiso"
                        @change="buscarPermiso">
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
                            <tr v-if="total_permisos==0">
                                <td class="text-center text-danger" colspan="7">-- Datos No Registrados --</td>
                            </tr>
                            <tr v-else v-for="(permiso,fila) in permisos.data">
                                <td class="text-center">@{{ permisos.from + fila }}</td>
                                <td v-text="permiso.name"></td>
                                <td v-text="permiso.guard_name"></td>
                                <td>
                                    <button type="button" class="btn bg-info btn-xs"
                                            title="Mostrar Permiso" @click="mostrarPermiso(permiso.id)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs"
                                            title="Editar Permiso" @click="editarPermiso(permiso.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs"
                                            title="Eliminar Permiso" @click="eliminarPermiso(permiso.id)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
                        <li v-if="permisos.current_page >=2" class="page-item">
                            <a href="" aria-label="First" class="page-link"
                            @click.prevent="changePagePermisos(0)">
                                <span><i class="fas fa-fast-backward"></i></span>
                            </a>
                        </li>
                        <li v-if="permisos.current_page > 1" class="page-item">
                            <a href="" aria-label="Previous" class="page-link"
                            @click.prevent="changePagePermisos(permisos.current_page - 1)">
                                <span><i class="fas fa-backward"></i></span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumberPermiso" class="page-item"
                            v-bind:class="[ page == isActivedPermiso ? 'active' : '']">
                            <a href="" class="page-link"
                                @click.prevent="changePagePermisos(page)">@{{ page }}</a>
                        </li>
                        <li v-if="permisos.current_page < permisos.last_page" class="page-item">
                            <a href="" aria-label="Next" class="page-link"
                                @click.prevent="changePagePermisos(permisos.current_page + 1)">
                                <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                            </a>
                        </li>
                        <li v-if="permisos.current_page < permisos.last_page-1" class="page-item">
                            <a href="" aria-label="Last" class="page-link"
                                @click.prevent="changePagePermisos(permisos.last_page)">
                                <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@include('sistema.permission.form')