<div class="row">
    <div class="col-md-4 mb-1">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">Mostrar Lote</span>
            </div>
            <select class="form-control" v-model="buscarLote.lote" @change="obtenerCongeladosLote">
                <option value="">--Seleccionar</option>
                <option V-for="l in filtroLotes" :key="l.id" :value="l.id" v-text="l.nombre"></option>
            </select>
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
                        <th>Lote</th>
                        <th>KG. Plaqueado</th>
                        <th>KG. Pelado Qu&iacute;mico</th>
                        <th>Fecha Registro.</th>
                        <th>Trabajador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_congelados==0" >
                        <td class="text-center text-danger" colspan="7">-- Lote No Seleccionado --</td>
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
                        <td>
                            <template v-if="congelado.deleted_at">
                                <button type="button" class="btn bg-purple btn-xs"
                                            title="Restaurar Congelado" @click="restaurar(congelado.id)">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn bg-info btn-xs"
                                        title="Mostrar Congelado" @click="mostrar(congelado.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs"
                                        title="Editar Congelado" @click="editar(congelado.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs"
                                        title="Eliminar Congelado" @click="eliminar(congelado.id)">
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
<div class="row" v-if="total_congelados>0">
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
<div class="form-group row callout callout-danger border border-secondary">
    <label class="col-form-label col-form-label-sm col-md-2">Total de Kilogramos congelados</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="totalKilogramoCongelado+' Kg.'">
    </div>
    <label class="col-form-label col-form-label-sm col-md-2">Rendimiento de la Etapa</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="rendimientoEtapa+' %'">
    </div>
    <label class="col-form-label col-form-label-sm col-md-2">Rendimiento desde el Principio</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="rendimientoPrincipio+' %'" >
    </div>
</div>