@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-box"></i>&nbsp;@{{ vista }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Materia prima</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i> Listado de Materias Primas
            &nbsp;
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevo">
                <i class="fas fa-plus"></i> Nueva Materia Prima
            </button>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" id="detalle-inicio">
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="pagina" @change="cambiarPaginacion" >
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
                        <a class="dropdown-item" href="#" @click.prevent="todos">Todos</a>
                        <a class="dropdown-item" href="#" @click.prevent="habilitados">Habilitados</a>
                        <a class="dropdown-item" href="#" @click.prevent="eliminados">Eliminados</a>
                    </div>
                    &nbsp;
                    <input type="text" name="table-search" id="table-search"
                        class="form-control"  placeholder="Buscar..." v-model="busqueda"
                        @keyup.enter="buscar">
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
                                <th>Descripci&oacute;n</th>
                                <th>Fecha Creada</th>
                                <th>Fecha Modificada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_materias == 0">
                                <td class="text-danger text-center" colspan="6">- Datos No Registrados -</td>
                            </tr>
                            <tr v-else v-for="(materia,fila) in materiaPrimas.data ">
                                <td>@{{  fila + materiaPrimas.from}}</td>
                                <td v-html="materia.nombre"></td>
                                <td v-html="materia.descripcion"></td>
                                <td v-html="materia.fecha_creada"></td>
                                <td v-html="materia.fecha_modificada"></td>
                                <td>
                                    <template v-if="materia.deleted_at">
                                        <button type="button" class="btn bg-purple btn-xs"
                                                    title="Restaurar Materia Prima" @click="restaurar(materia.id)">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn bg-info btn-xs"
                                                title="Mostrar Materia Prima" @click="mostrar(materia.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs"
                                                title="Editar Materia prima" @click="editar(materia.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs"
                                                title="Eliminar Materia Prima" @click="eliminar(materia.id)">
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
@include('materia-prima.form')
@include('materia-prima.mostrar')
@endsection

@section('scripties')
    <script src="{{asset('js/materia-prima.js') }}"></script>
@endsection