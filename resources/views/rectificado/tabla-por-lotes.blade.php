<div class="row">
    <div class="col-md-4 mb-1">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">Mostrar Lote</span>
            </div>
            <select class="form-control" v-model="buscarLote.lote" @change="obtenerRecitificadosLote">
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
                        <th>KG. Rectificado</th>
                        <th>KG. Pelado Qu&iacute;mico</th>
                        <th>Fecha Registro.</th>
                        <th>trabajador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_rectificados==0" >
                        <td class="text-center text-danger" colspan="7">-- Lote No Seleccionado --</td>
                    </tr>
                    <tr v-else v-for="(rectificado, fila) in rectificados.data">
                        <td class="text-center">@{{ fila + rectificados.from }}</td>
                        <td class="text-center" v-text="rectificado.lote.nombre"></td>
                        <td class="text-center"> 
                            @{{ (parseFloat(rectificado.kilogramo_rectificado)).toFixed(2) }}
                        </td>
                        <td class="text-center">
                            <template v-for="pelado in rectificado.lote.pelado_quimicos">
                                @{{ (parseFloat(pelado.kilogramo)).toFixed(2) }}
                            </template>
                        </td>
                        <td class="text-center" v-text="rectificado.fecha"></td>
                        <td>
                            @{{ rectificado.trabajador.nombres+' '+rectificado.trabajador.apellidos}}
                        </td>
                        <td>
                            <template v-if="rectificado.deleted_at">
                                <button type="button" class="btn bg-purple btn-xs"
                                            title="Restaurar Rectificado" @click="restaurar(rectificado.id)">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn bg-info btn-xs"
                                        title="Mostrar Rectificado" @click="mostrar(rectificado.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs"
                                        title="Editar Rectificado" @click="editar(rectificado.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs"
                                        title="Eliminar Rectificado" @click="eliminar(rectificado.id)">
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
<div class="row" v-if="total_rectificados>0">
    <div class="col-md-12">
        <nav>
            <ul class="pagination">
                <li v-if="rectificados.current_page >=2" class="page-item">
                    <a href="" aria-label="First" class="page-link"
                    @click.prevent="changePage(0)">
                        <span><i class="fas fa-fast-backward"></i></span>
                    </a>
                </li>
                <li v-if="rectificados.current_page > 1" class="page-item">
                    <a href="" aria-label="Previous" class="page-link"
                    @click.prevent="changePage(rectificados.current_page - 1)">
                        <span><i class="fas fa-backward"></i></span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" class="page-item"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="" class="page-link"
                        @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="rectificados.current_page < rectificados.last_page" class="page-item">
                    <a href="" aria-label="Next" class="page-link"
                        @click.prevent="changePage(rectificados.current_page + 1)">
                        <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                    </a>
                </li>
                <li v-if="rectificados.current_page < rectificados.last_page-1" class="page-item">
                    <a href="" aria-label="Last" class="page-link"
                        @click.prevent="changePage(rectificados.last_page)">
                        <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="form-group row callout callout-danger border border-secondary">
    <label class="col-form-label col-form-label-sm col-md-2">Total de Kilogramos rectificados</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="totalKilogramoRectificado+' Kg.'">
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