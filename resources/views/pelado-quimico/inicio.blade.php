@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-carrot"></i>&nbsp;@{{ vista }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Pelado Qu&iacute;mico</li>
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
            <i class="fas fa-carrot"></i> Listado
            &nbsp;
            <button type="button" class="btn btn-danger btn-sm"
                title="Nuevo usuario" @click="nuevo">
                <i class="fas fa-plus"></i> Nuevo
            </button>
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
                                <th class="text-center">LOTE</th>
                                <th class="text-center">KG. Pelado Qu&iacute;mico</th>
                                <th class="text-center">KG. Ingreso (maduro)</th>
                                <th class="text-center">Rendimiento</th>
                                <th class="text-center">Fecha Registro</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="total_pelado==0">
                                <td class="text-danger text-center" colspan="11">- Datos No Registrados -</td>
                            </tr>
                            <tr v-else v-for="(pelado,fila) in peladoQuimicos.data">
                                <td class="text-center">@{{ fila + peladoQuimicos.from }}</td>
                                <td class="text-center" v-text="pelado.lote.nombre"></td>
                                <td class="text-center"> 
                                    @{{ (parseFloat(pelado.kilogramo)).toFixed(2) }}
                                </td>
                                <td class="text-center"> 
                                    @{{ (parseFloat(pelado.lote.maduros)).toFixed(2) }}
                                </td>
                                <td class="text-center"> 
                                    @{{ (parseFloat((pelado.kilogramo/pelado.lote.maduros)*100)).toFixed(2)+'%' }}
                                </td>
                                <td class="text-center" v-text="pelado.fecha"></td>
                                <td class="text-center">
                                    <template v-if="pelado.deleted_at">
                                        <button type="button" class="btn bg-purple btn-xs"
                                                    title="Restaurar pelado" @click="restaurar(pelado.id)">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn bg-info btn-xs"
                                                title="Mostrar pelado" @click="mostrar(pelado.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs"
                                                title="Editar pelado" @click="editar(pelado.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs"
                                                title="Eliminar pelado" @click="eliminar(pelado.id)">
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

@include('pelado-quimico.form')
@include('pelado-quimico.mostrar')

@endsection

@section('scripties')
    <script src="{{asset('js/pelado-quimico.js') }}"></script>
@endsection