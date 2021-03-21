@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-cogs"></i> Sistema @{{ (vista) ? ' - '+vista:'' }} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Sistema</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <button type="button" class="btn btn-primary" @click="cambiarVista('Usuarios')">
            <i class="fas fa-users"></i><br>Usuarios
        </button>
        <button type="button" class="btn bg-purple" @click="cambiarVista('Trabajadores')">
            <i class="fas fa-user-tie"></i><br>Trabajadores
        </button>
    </div>
    <!-- /.card-header -->
    <div class="card-body" id="detalle-inicio">
        <template v-if="vista=='Usuarios'">@include('sistema.usuario.inicio')</template>
        <template v-else-if="vista=='Trabajadores'">@include('sistema.trabajador.inicio')</template>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('scripties')
    <script src="{{asset('js/sistema.js') }}"></script>
@endsection
