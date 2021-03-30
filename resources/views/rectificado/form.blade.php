<div class="modal fade" id="modal-rectificado">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-rectificado-title">Nuevo Rectificado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-rectificado-body">
                <div class="form-group row">
                    <label for="" class='col-md-1 col-form-label col-form-label-sm'>Lote</label>
                    <div class="col-md-9">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid' : errores.materia_prima_id }" placeholder="Buscar Materia Prima"
                            v-model="peladoQuimico.lote_nombre" @change="buscarLotes" />
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
            </div>
        </div>
    </div>
</div>