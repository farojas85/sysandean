@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fab fa-buffer"></i>&nbsp;@{{ vista }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Plaqueado</li>
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
            <i class="fab fa-buffer"></i> Listado de Plaqueados
            &nbsp;
            @can('plaqueados.crear')
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevo">
                <i class="fas fa-plus"></i> Nuevo
            </button>
            @endcan
        </h3>
    </div>
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
                        <a class="dropdown-item" href="#" @click.prevent="porLotes">Por Lotes</a>
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
        <template v-if="filtroPorLotes">
            @include('plaqueado.tabla-por-lotes')
        </template>
        <template v-else>
            <div class="row">
                <div class="col-md-12 mb-1" id="detalle-tabla">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <thead class="bg-navy">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Lote</th>
                                    <th>KG. Plaqueado</th>
                                    <th>KG. Pelado Qu&iacute;mico</th>
                                    <th>Fecha Registro.</th>
                                    <th>trabajador</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="total_plaqueados==0" >
                                    <td class="text-center text-danger" colspan="7">--Datos No Registrados--</td>
                                </tr>
                                <tr v-else v-for="(plaqueado, fila) in plaqueados.data">
                                    <td class="text-center">@{{ fila + plaqueados.from }}</td>
                                    <td class="text-center" v-text="plaqueado.lote.nombre"></td>
                                    <td class="text-center"> 
                                        @{{ (parseFloat(plaqueado.kilogramo_plaqueado)).toFixed(2) }}
                                    </td>
                                    <td class="text-center">
                                        <template v-for="pelado in plaqueado.lote.pelado_quimicos">
                                            @{{ (parseFloat(pelado.kilogramo)).toFixed(2) }}
                                        </template>
                                    </td>
                                    <td class="text-center" v-text="plaqueado.fecha"></td>
                                    <td>
                                        @{{ plaqueado.trabajador.nombres+' '+plaqueado.trabajador.apellidos}}
                                    </td>
                                    <td class="text-center">
                                        <template v-if="plaqueado.deleted_at">
                                            @can('plaqueados.restaurar')
                                            <button type="button" class="btn bg-purple btn-xs"
                                                        title="Restaurar Plaqueado" @click="restaurar(plaqueado.id)">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                            @endcan
                                        </template>
                                        <template v-else>
                                            @can('plaqueados.mostrar')
                                            <button type="button" class="btn bg-info btn-xs"
                                                    title="Mostrar Plaqueado" @click="mostrar(plaqueado.id)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @endcan
                                            @can('plaqueados.editar')
                                            <button type="button" class="btn btn-warning btn-xs"
                                                    title="Editar Plaqueado" @click="editar(plaqueado.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endcan
                                            @can('plaqueados.eliminar')
                                            <button type="button" class="btn btn-danger btn-xs"
                                                    title="Eliminar Plaqueado" @click="eliminar(plaqueado.id)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @endcan
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
                            <li v-if="plaqueados.current_page >=2" class="page-item">
                                <a href="" aria-label="First" class="page-link"
                                @click.prevent="changePage(0)">
                                    <span><i class="fas fa-fast-backward"></i></span>
                                </a>
                            </li>
                            <li v-if="plaqueados.current_page > 1" class="page-item">
                                <a href="" aria-label="Previous" class="page-link"
                                @click.prevent="changePage(plaqueados.current_page - 1)">
                                    <span><i class="fas fa-backward"></i></span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber" class="page-item"
                                v-bind:class="[ page == isActived ? 'active' : '']">
                                <a href="" class="page-link"
                                    @click.prevent="changePage(page)">@{{ page }}</a>
                            </li>
                            <li v-if="plaqueados.current_page < plaqueados.last_page" class="page-item">
                                <a href="" aria-label="Next" class="page-link"
                                    @click.prevent="changePage(plaqueados.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                                </a>
                            </li>
                            <li v-if="plaqueados.current_page < plaqueados.last_page-1" class="page-item">
                                <a href="" aria-label="Last" class="page-link"
                                    @click.prevent="changePage(plaqueados.last_page)">
                                    <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </template>
    </div>
</div>
@include('plaqueado.form')
@include('plaqueado.mostrar')
@endsection

@section('scripties')
    <script src="{{asset('js/plaqueado.js') }}"></script>
@endsection