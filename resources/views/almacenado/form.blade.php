<div class="modal fade" id="modal-almacenado">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-almacenado-title">Nuevo Almacenado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-almacenado-body">
                <div class="form-group row">
                    <label for="" class='col-md-1 col-form-label col-form-label-sm'>Lote</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid' : errores.lote_id }" placeholder="Buscar Lote"
                            v-model="almacenado.lote_nombre" @change="buscarLotes" />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-xs">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                          </div>
                        <small class="text-danger font-weight-bold" v-for="error in errores.lote_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form group row" v-if="lotes_count>0">
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm" v-if="lotes_count>=1">
                            <thead class="thead-dark">
                                <th>#</th>
                                <th>Nombre Lote</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-if="lotes_count == 1">
                                    <td class="text-center text-danger">- Datos No Encontrados -</td>
                                </tr>
                                <tr v-else v-for="(lote,fila) in lotes.data">
                                    <td>@{{ fila +1  }}</td>
                                    <td v-text="lote.nombre"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs"
                                            @click="seleccionarLote(lote)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Cajas</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Número de Cajas"
                            v-model="almacenado.cajas" :class="{ 'is-invalid' : errores.cajas }" />
                        <small class="text-danger font-weight-bold" v-for="error in errores.cajas">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Peso Cajas</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese Peso Cajas"
                            v-model="almacenado.peso_caja" :class="{ 'is-invalid' : errores.peso_caja }" />
                        <small class="text-danger font-weight-bold" v-for="error in errores.peso_caja">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm' title="Fecha Registro">Fecha Registro</label>
                    <div class="col-md-8 ">
                        <input type="date" class="form-control form-control-sm" placeholder="Seleccione Fecha"
                            v-model="almacenado.fecha_registro" :class="{ 'is-invalid' : errores.fecha_registro }"/>
                        <small class="text-danger font-weight-bold" v-for="error in errores.fecha_registro">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm' title="Fecha Registro">Trabajador</label>
                    <div class="col-md-8 ">
                        <select v-model="almacenado.trabajador_id" class="form-control form-control-sm" >
                            <option value="">-Seleccionar-</option>
                            <option v-for="t in trabajadores" :key="t.id" :value="t.id" v-text="t.nombres"></option>
                        </select>
                        <small class="text-danger font-weight-bold" v-for="error in errores.trabajador_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class='col-md-3 col-form-label col-form-label-sm'>Observaciones</label>
                    <div class="col-md-8 ">
                        <textarea rows="2" class="form-control form-control-sm" placeholder="Ingrese Obseración"
                            v-model="almacenado.observacion" ></textarea>
                        <small class="text-danger font-weight-bold" v-for="error in errores.observacion">@{{ error }}</small>
                    </div>
                </div>
                <div class="modal-footer form-group text-center">
                    <button type="button" class="btn btn-danger" id="btn-cerrar" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                    &nbsp;
                    <button type="submit" class="btn btn-success btn-guardar-materia" :value='almacenado.estadoCrud'
                            name="btn-guardar-materia" @click.prevent="guardar">
                            <i :class="(almacenado.estadoCrud == 'nuevo') ? 'fa fa-save' : 'fa fa-refresh'"></i>  
                        @{{ ( almacenado.estadoCrud == 'nuevo' ? 'Guardar' : 'Actualizar')}}
                    </button> 
                </div>
            </div>
        </div>
    </div>
</div>