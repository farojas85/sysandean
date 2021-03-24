<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Usuarios&nbsp;
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevoUsuario">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </button>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" id="listado-usuarios">
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="pagina_usuario" @change="cambiarPaginacionUsuario" >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>&nbsp;
                    <button type="button" class="btn bg-purple btn-sm dropdown-toggle"
                            data-toggle="dropdown">
                        Filtros
                    </button>
                    <div class="dropdown-menu ">
                        <a class="dropdown-item" href="#" @click.prevent="usuariosTodos">Todos</a>
                        <a class="dropdown-item" href="#" @click.prevent="usuariosHabilitados">Habilitados</a>
                        <a class="dropdown-item" href="#" @click.prevent="usuariosEliminados">Eliminados</a>
                    </div>
                    &nbsp;
                    <input type="text" name="table-search" id="table-search"
                        class="form-control"  placeholder="Buscar..." v-model="buscar_usuario"
                        @keyup.enter="buscarUsuario">
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
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_usuarios==0">
                                <td class="text-center text-danger" colspan="7">-- Datos No Registrados --</td>
                            </tr>
                            <tr v-else v-for="(usuario,fila) in usuarios.data">
                                <td class="text-center">@{{ usuarios.from + fila }}</td>
                                <td v-text="usuario.nombre"></td>
                                <td v-text="usuario.usuario"></td>
                                <td v-text="usuario.email"></td>
                                <td class="text-center">
                                    <span v-for="role in usuario.roles">
                                        @{{ role.name }}
                                    </span>
                                </td>
                                <td>
                                    <span :class="usuario.estado_clase">@{{usuario.estado_nombre }}</span>
                                </td>
                                <td>
                                    <template v-if="usuario.deleted_at">
                                        <button type="button" class="btn bg-purple btn-xs"
                                                    title="Restaurar Usuario" @click="restaurarUsuario(usuario.id)">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn bg-info btn-xs"
                                                title="Mostrar Usuario" @click="mostrarUsuario(usuario.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs"
                                                title="Editar Usuario" @click="editarUsuario(usuario.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs"
                                                title="Eliminar Usuario" @click="eliminarUsuario(usuario.id)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </template>
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
                        <li v-if="usuarios.current_page >=2" class="page-item">
                            <a href="" aria-label="First" class="page-link"
                            @click.prevent="changePageUsuarios(0)">
                                <span><i class="fas fa-fast-backward"></i></span>
                            </a>
                        </li>
                        <li v-if="usuarios.current_page > 1" class="page-item">
                            <a href="" aria-label="Previous" class="page-link"
                            @click.prevent="changePageUsuarios(usuarios.current_page - 1)">
                                <span><i class="fas fa-backward"></i></span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumberUsuario" class="page-item"
                            v-bind:class="[ page == isActivedUsuario ? 'active' : '']">
                            <a href="" class="page-link"
                                @click.prevent="changePageUsuarios(page)">@{{ page }}</a>
                        </li>
                        <li v-if="usuarios.current_page < usuarios.last_page" class="page-item">
                            <a href="" aria-label="Next" class="page-link"
                                @click.prevent="changePageUsuarios(usuarios.current_page + 1)">
                                <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                            </a>
                        </li>
                        <li v-if="usuarios.current_page < usuarios.last_page-1" class="page-item">
                            <a href="" aria-label="Last" class="page-link"
                                @click.prevent="changePageUsuarios(usuarios.last_page)">
                                <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
@include('sistema.usuario.form')
@include('sistema.usuario.mostrar')
        
