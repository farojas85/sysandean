<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            Listado Trabajador&nbsp;
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevoTrabajador">
                <i class="fas fa-plus"></i> Nuevo Trabajador
            </button>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" id="listado-trabajadores">
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="pagina_usuario" @change="cambiarPaginacionTrabajador">
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
                        <a class="dropdown-item" href="#" @click.prevent="trabajadoresTodos">Todos</a>
                        <a class="dropdown-item" href="#" @click.prevent="trabajadoresHabilitados">Habilitados</a>
                        <a class="dropdown-item" href="#" @click.prevent="trabajadoresEliminados">Eliminados</a>
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
                                <th>Numero Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Lugar Nacimiento</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_trabajadores==0">
                                <td class="text-center text-danger" colspan="7">-- Datos No Registrados --</td>
                            </tr>
                            <tr v-else v-for="(trabajador,fila) in trabajadores.data">
                                <td class="text-center">@{{ trabajadores.from + fila }}</td>
                                <td v-text="trabajador.numero_documento"></td>
                                <td v-text="trabajador.nombres"></td>
                                <td v-text="trabajador.apellidos"></td>
                                <td v-text="trabajador.lugar_nacimiento"></td>
                                <td class="text-center">
                                    <span :class="trabajador.estado_clase">@{{trabajador.estado_nombre }}</span>
                                </td>
                                <td>
                                    <template v-if="trabajador.deleted_at">
                                        <button type="button" class="btn bg-purple btn-xs"
                                                    title="Restaurar Trabajador" @click="restaurarTrabajador(trabajador.id)">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn bg-info btn-xs"
                                                title="Mostrar Trabajador" @click="mostrarTrabajador(trabajador.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs"
                                                title="Editar Trabajador" @click="editarTrabajador(trabajador.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs"
                                                title="Eliminar Trabajador" @click="eliminarTrabajador(trabajador.id)">
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
    </div>
</div>
@include('sistema.trabajador.form')
@include('sistema.trabajador.mostrar')