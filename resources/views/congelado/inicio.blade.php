@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-icicles"></i>&nbsp;@{{ vista }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Congelado</li>
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
            <i class="fas fa-icicles"></i> Listado de Congelados
            &nbsp;
            @can('congelados.crear')
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
            @include('congelado.tabla-por-lotes')
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
                                    <th>KG. Congelados</th>
                                    <th>KG. Pelado Qu&iacute;mico</th>
                                    <th>Fecha Registro.</th>
                                    <th>Trabajador</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="total_congelados==0" >
                                    <td class="text-center text-danger" colspan="7">--Datos No Registrados--</td>
                                </tr>
                                <tr v-else v-for="(congelado, fila) in congelados.data">
                                    <td class="text-center">@{{ fila + congelados.from }}</td>
                                    <td class="text-center" v-text="congelado.lote.nombre"></td>
                                    <td class="text-center"> 
                                        @{{ (parseFloat(congelado.kilogramo_congelado)).toFixed(2) }}
                                    </td>
                                    <td class="text-center">
                                        <template v-for="pelado in congelado.lote.pelado_quimicos">
                                            @{{ (parseFloat(pelado.kilogramo)).toFixed(2) }}
                                        </template>
                                    </td>
                                    <td class="text-center" v-text="congelado.fecha"></td>
                                    <td>
                                        @{{ congelado.trabajador.nombres+' '+congelado.trabajador.apellidos}}
                                    </td>
                                    <td class="text-center">
                                        <template v-if="congelado.deleted_at">
                                            @can('congelados.restaurar')
                                            <button type="button" class="btn bg-purple btn-xs"
                                                        title="Restaurar congelado" @click="restaurar(congelado.id)">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                            @endcan
                                        </template>
                                        <template v-else>
                                            @can('congelados.mostrar')
                                            <button type="button" class="btn bg-info btn-xs"
                                                    title="Mostrar congelado" @click="mostrar(congelado.id)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @endcan
                                            @can('congelados.editar')
                                            <button type="button" class="btn btn-warning btn-xs"
                                                    title="Editar congelado" @click="editar(congelado.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endcan
                                            @can('congelados.eliminar')
                                            <button type="button" class="btn btn-danger btn-xs"
                                                    title="Eliminar congelado" @click="eliminar(congelado.id)">
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
                            <li v-if="congelados.current_page >=2" class="page-item">
                                <a href="" aria-label="First" class="page-link"
                                @click.prevent="changePage(0)">
                                    <span><i class="fas fa-fast-backward"></i></span>
                                </a>
                            </li>
                            <li v-if="congelados.current_page > 1" class="page-item">
                                <a href="" aria-label="Previous" class="page-link"
                                @click.prevent="changePage(congelados.current_page - 1)">
                                    <span><i class="fas fa-backward"></i></span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber" class="page-item"
                                v-bind:class="[ page == isActived ? 'active' : '']">
                                <a href="" class="page-link"
                                    @click.prevent="changePage(page)">@{{ page }}</a>
                            </li>
                            <li v-if="congelados.current_page < congelados.last_page" class="page-item">
                                <a href="" aria-label="Next" class="page-link"
                                    @click.prevent="changePage(congelados.current_page + 1)">
                                    <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                                </a>
                            </li>
                            <li v-if="congelados.current_page < congelados.last_page-1" class="page-item">
                                <a href="" aria-label="Last" class="page-link"
                                    @click.prevent="changePage(congelados.last_page)">
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
@include('congelado.form')
@include('congelado.mostrar')
@endsection

@section('scripties')
    <script src="{{asset('js/congelado.js') }}"></script>
@endsection