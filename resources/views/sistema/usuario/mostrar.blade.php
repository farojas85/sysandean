<div class="form-group row">
    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Nombres</label>
    <div class="col-md-8">
        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Nombres"
            v-model="usuario.nombre" readonly/>
        <small class="text-danger" v-for="error in errores.nombre">@{{ error }}</small>
    </div>
</div>
<div class="form-group row">
    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Usuario</label>
    <div class="col-md-8">
        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Usuario"
            v-model="usuario.usuario" readonly/>
        <small class="text-danger" v-for="error in errores.usuario">@{{ error }}</small>
    </div>
</div>
<div class="form-group row">
    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Nombres</label>
    <div class="col-md-8">
        <input type="email" class="form-control form-control-sm" placeholder="Ingrese Correo"
            v-model="usuario.email" readonly/>
        <small class="text-danger" v-for="error in errores.email">@{{ error }}</small>
    </div>
</div>
<div class="form-group row">
    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Estado</label>
    <div class="col-md-8">
        <input type="checkbox" v-model="usuario.estado" />
        @{{ usuario.estado ? 'Activo' : 'Inactivo'}}
        {{-- <small class="text-danger" v-for="error in errores.estado">@{{ error }}</small> --}}
    </div>
</div>
<div class="form-group text-center">
    <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
        <i class="mdi mdi-close "></i> Cerrar
    </button>
</div>