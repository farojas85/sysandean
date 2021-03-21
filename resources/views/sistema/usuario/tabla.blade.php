<div class="row">
    <div class="col-md-12 mb-1 table-responsive">
        <div class="input-group input-group-sm">
            <div class="input-group-append">
                <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                <select class="custom-select custom-select-sm form-control form-control-sm"
                        v-model="pagina" >
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
                <a class="dropdown-item" href="#">Todos</a>
                <a class="dropdown-item" href="#" >Habilitados</a>
                <a class="dropdown-item" href="#" >Eliminados</a>
            </div>
            &nbsp;
            <input type="text" name="table-search" id="table-search"
                class="form-control"  placeholder="Buscar..." >
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
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->usuario }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td class="text-center">
                            <span class="{{ $usuario->estado_clase }}">
                                {{ $usuario->estado_nombre }}
                            </span>
                        </td>
                        <td>
                            @if (is_null($usuario->deleted_at))
                            <button type="button" class="btn bg-info btn-xs"
                                    title="Mostrar Usuario">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-xs"
                                    title="Editar Usuario">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs"
                                    title="Eliminar Usuario">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @else
                            <button type="button" class="btn bg-purple btn-xs"
                                     title="Restaurar Usuario">
                                <i class="fas fa-trash-restore"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $usuarios->links()}}
    </div>
</div>