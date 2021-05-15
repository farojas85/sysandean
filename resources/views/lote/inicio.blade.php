@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-clone"></i>&nbsp;@{{ vista }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Lote</li>
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
            <i class="fas fa-clone"></i> Listado de Lotes
            &nbsp;
            @can('lotes.crear')
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevo">
                <i class="fas fa-plus"></i> Nuevo Lote
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
                    <table class="table table-sm table-striped table-bordered table-hover">
                        <thead class="bg-navy">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>KG.</th>
                                <th>Descripci&oacute;n</th>
                                <th>Fecha Reg.</th>
                                <th>Maduros</th>
                                <th>Pinton</th>
                                <th>Verde</th>
                                <th>Podrido</th>
                                <th>Peque&ntilde;o</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_lotes==0">
                                <td class="text-danger text-center" colspan="11">- Datos No Registrados -</td>
                            </tr>
                            <tr v-else v-for="(lote,fila) in lotes.data">
                                <td>@{{ fila + lotes.from }}</td>
                                <td v-text="lote.nombre"></td>
                                <td v-text="lote.kilogramo"></td>
                                <td v-text="lote.descripcion"></td>
                                <td v-text="lote.fecha"></td>
                                <td class="text-center">@{{ lote.maduros +'|'+ (parseFloat(lote.maduros_lote)).toFixed(1)+'%' }}</td>
                                <td class="text-center">@{{ lote.pinton +'|'+ (parseFloat(lote.pinton_lote)).toFixed(1)+'%' }}</td>
                                <td class="text-center">@{{ lote.verde +'|'+ (parseFloat(lote.verde_lote)).toFixed(1)+'%' }}</td>
                                <td class="text-center">@{{ lote.podrido +'|'+ (parseFloat(lote.podrido_lote)).toFixed(1)+'%' }}</td>
                                <td class="text-center">@{{ lote.enanas +'|'+ (parseFloat(lote.enanas_lote)).toFixed(1)+'%' }}</td>
                                <td>
                                    <template v-if="lote.deleted_at">
                                        @can('lotes.restaurar')
                                        <button type="button" class="btn bg-purple btn-xs"
                                                    title="Restaurar Lote" @click="restaurar(lote.id)">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                        @endcan
                                    </template>
                                    <template v-else>
                                        @can('lotes.mostrar')
                                        <button type="button" class="btn bg-info btn-xs"
                                                title="Mostrar lote" @click="mostrar(lote.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @endcan
                                        @can('lotes.editar')
                                        <button type="button" class="btn btn-warning btn-xs"
                                                title="Editar lote" @click="editar(lote.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @endcan
                                        @can('lotes.eliminar')
                                        <button type="button" class="btn btn-danger btn-xs"
                                                title="Eliminar lote" @click="eliminar(lote.id)">
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
                        <li v-if="lotes.current_page >=2" class="page-item">
                            <a href="" aria-label="First" class="page-link"
                            @click.prevent="changePage(0)">
                                <span><i class="fas fa-fast-backward"></i></span>
                            </a>
                        </li>
                        <li v-if="lotes.current_page > 1" class="page-item">
                            <a href="" aria-label="Previous" class="page-link"
                            @click.prevent="changePage(lotes.current_page - 1)">
                                <span><i class="fas fa-backward"></i></span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber" class="page-item"
                            v-bind:class="[ page == isActived ? 'active' : '']">
                            <a href="" class="page-link"
                                @click.prevent="changePage(page)">@{{ page }}</a>
                        </li>
                        <li v-if="lotes.current_page < lotes.last_page" class="page-item">
                            <a href="" aria-label="Next" class="page-link"
                                @click.prevent="changePage(lotes.current_page + 1)">
                                <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                            </a>
                        </li>
                        <li v-if="lotes.current_page < lotes.last_page-1" class="page-item">
                            <a href="" aria-label="Last" class="page-link"
                                @click.prevent="changePage(lotes.last_page)">
                                <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@include('lote.form')
@include('lote.mostrar')
@endsection

@section('scripties')
    <script src="{{asset('js/lote.js') }}"></script>
@endsection