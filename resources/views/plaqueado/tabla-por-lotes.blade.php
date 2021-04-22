<div class="row">
    <div class="col-md-4 mb-1">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">Mostrar Lote</span>
            </div>
            <select class="form-control" v-model="buscarLote.lote" @change="obtenerPlaqueadosLote">
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
                        <th>KG. Rectificado</th>
                        <th>Fecha Registro.</th>
                        <th>trabajador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_plaqueados==0" >
                        <td class="text-center text-danger" colspan="7">-- Lote No Seleccionado --</td>
                    </tr>
                    <tr v-else v-for="(plaqueado, fila) in plaqueados.data">
                        <td class="text-center">@{{ fila + plaqueados.from }}</td>
                        <td class="text-center" v-text="plaqueado.lote.nombre"></td>
                        <td class="text-center"> 
                            @{{ (parseFloat(plaqueado.kilogramo_plaqueado)).toFixed(2) }}
                        </td>
                        <td class="text-center">
                            <template v-for="rectificado in plaqueado.lote.rectificados">
                                @{{ (parseFloat(rectificado.kilogramo_rectificado)).toFixed(2) }}
                            </template>
                        </td>
                        <td class="text-center" v-text="plaqueado.fecha"></td>
                        <td>
                            @{{ plaqueado.trabajador.nombres+' '+plaqueado.trabajador.apellidos}}
                        </td>
                        <td>
                            <template v-if="plaqueado.deleted_at">
                                <button type="button" class="btn bg-purple btn-xs"
                                            title="Restaurar plaqueado" @click="restaurar(plaqueado.id)">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn bg-info btn-xs"
                                        title="Mostrar plaqueado" @click="mostrar(plaqueado.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs"
                                        title="Editar plaqueado" @click="editar(plaqueado.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs"
                                        title="Eliminar plaqueado" @click="eliminar(plaqueado.id)">
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
<div class="row" v-if="total_plaqueados>0">
    <div class="col-md-12">
        <nav>
            <ul class="pagination">
                <li v-if="plaqueados.current_page >=2" class="page-item">
                    <a href="" aria-label="First" class="page-link"
                    @click.prevent="changePage(0)">
                        <span><i class="fas fa-fast-backward"></i></span>
                    </a>
                </li>
                <li v-if="plaqueados.current_page > 1" class="page-item">
                    <a href="" aria-label="Previous" class="page-link"
                    @click.prevent="changePage(plaqueados.current_page - 1)">
                        <span><i class="fas fa-backward"></i></span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" class="page-item"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="" class="page-link"
                        @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="plaqueados.current_page < plaqueados.last_page" class="page-item">
                    <a href="" aria-label="Next" class="page-link"
                        @click.prevent="changePage(plaqueados.current_page + 1)">
                        <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                    </a>
                </li>
                <li v-if="plaqueados.current_page < plaqueados.last_page-1" class="page-item">
                    <a href="" aria-label="Last" class="page-link"
                        @click.prevent="changePage(plaqueados.last_page)">
                        <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="form-group row callout callout-danger border border-secondary">
    <label class="col-form-label col-form-label-sm col-md-2">Total de Kilogramos plaqueados</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="totalKilogramoPlaqueado+' Kg.'">
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