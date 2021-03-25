<div class="modal fade" id="modal-lote">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-lote-title">Nuevo Lote</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-lote-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Nombre</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid' : errores.nombre }" placeholder="Ingrese Nombre"
                                            v-model="lote.nombre"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.nombre">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Materia Prima</label>
                                    <div class="col-md-8">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid' : errores.materia_prima_id }" placeholder="Buscar Materia Prima"
                                            v-model="lote.materia_prima_nombre" @change="buscarMateriaPrimas" />
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-info btn-xs">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            {{-- <input type="text" class="form-control" placeholder="Username"> --}}
                                          </div>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.materia_prima_id">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form group row" v-if="materiaPrimas_count>0">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm" v-if="materiaPrimas_count>=1">
                                            <thead class="thead-dark">
                                                <th>#</th>
                                                <th>Materia prima</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr v-if="materiaPrimas_count == 1">
                                                    <td class="text-center text-danger">- Datos No Encontrados -</td>
                                                </tr>
                                                <tr v-else v-for="(materia,fila) in materiaPrimas.data">
                                                    <td>@{{ fila +1  }}</td>
                                                    <td v-text="materia.nombre"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-xs"
                                                            @click="seleccionarMateriaPrima(materia)">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Kilogramos</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Kilogramos"
                                            v-model="lote.kilogramo" :class="{ 'is-invalid' : errores.kilogramo }" />
                                        <small class="text-danger font-weight-bold" v-for="error in errores.kilogramo">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Descripci&oacute;n</label>
                                    <div class="col-md-8 ">
                                        <textarea rows="2" class="form-control form-control-sm" placeholder="Ingrese Descripción"
                                            v-model="lote.descripcion" ></textarea>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.descripcion">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Fecha Registro</label>
                                    <div class="col-md-8 ">
                                        <input type="date" class="form-control form-control-sm" placeholder="Seleccione Fecha"
                                            v-model="lote.fecha_registro" :class="{ 'is-invalid' : errores.fecha_registro }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.fecha_registro">@{{ error }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-success">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Maduros</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Maduros"
                                            v-model="lote.maduros" :class="{ 'is-invalid' : errores.maduros }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.maduros">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Pint&oacute;n</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Pintón"
                                            v-model="lote.pinton" :class="{ 'is-invalid' : errores.pinton }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.pinton">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Verde</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Verdes"
                                            v-model="lote.verde" :class="{ 'is-invalid' : errores.verde }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.verde">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Podridos</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Podridos"
                                            v-model="lote.podrido" :class="{ 'is-invalid' : errores.podrido }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.podrido">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class='col-md-4 col-form-label col-form-label-sm'>Peque&ntilde;os</label>
                                    <div class="col-md-8 ">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Pequeños"
                                            v-model="lote.enanas" :class="{ 'is-invalid' : errores.enanas }"/>
                                        <small class="text-danger font-weight-bold" v-for="error in errores.enanas">@{{ error }}</small>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="errores.coincide">
                                    <div class="col-md-12">
                                        <small class="text-danger font-weight-bold" v-for="error in errores.coincide">@{{ error }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer form-group text-center">
                <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                &nbsp;
                <button type="submit" class="btn btn-success btn-guardar-materia" :value='lote.estadoCrud'
                        name="btn-guardar-materia" @click.prevent="guardar">
                        <i :class="(lote.estadoCrud == 'nuevo') ? 'fa fa-save' : 'fa fa-refresh'"></i>  
                    @{{ ( lote.estadoCrud == 'nuevo' ? 'Guardar' : 'Actualizar')}}
                </button> 
            </div>
            </div>
        </div>
    </div>
</div>