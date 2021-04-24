<div class="row">
    <div class="col-md-4 mb-1">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">Mostrar Lote</span>
            </div>
            <select class="form-control" v-model="buscarLote.lote" @change="obtenerAlmacenadosLote">
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
                        <th>Cajas</th>
                        <th>KG. Pelado Qu&iacute;mico</th>
                        <th>Fecha Registro.</th>
                        <th>Trabajador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_almacenados==0" >
                        <td class="text-center text-danger" colspan="7">-- Lote No Seleccionado --</td>
                    </tr>
                    <tr v-else v-for="(almacenado, fila) in almacenados.data">
                        <td class="text-center">@{{ fila + almacenados.from }}</td>
                        <td class="text-center" v-text="almacenado.lote.nombre"></td>
                        <td class="text-center"> 
                            @{{ (parseFloat(almacenado.cajas)).toFixed(2) }}
                        </td>
                        <td class="text-center">
                            <template v-for="pelado in almacenado.lote.pelado_quimicos">
                                @{{ (parseFloat(pelado.kilogramo)).toFixed(2) }}
                            </template>
                        </td>
                        <td class="text-center" v-text="almacenado.fecha"></td>
                        <td>
                            @{{ almacenado.trabajador.nombres+' '+almacenado.trabajador.apellidos}}
                        </td>
                        <td>
                            <template v-if="almacenado.deleted_at">
                                <button type="button" class="btn bg-purple btn-xs"
                                            title="Restaurar almacenado" @click="restaurar(almacenado.id)">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn bg-info btn-xs"
                                        title="Mostrar almacenado" @click="mostrar(almacenado.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs"
                                        title="Editar almacenado" @click="editar(almacenado.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs"
                                        title="Eliminar almacenado" @click="eliminar(almacenado.id)">
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
<div class="row" v-if="total_almacenados>0">
    <div class="col-md-12">
        <nav>
            <ul class="pagination">
                <li v-if="almacenados.current_page >=2" class="page-item">
                    <a href="" aria-label="First" class="page-link"
                    @click.prevent="changePage(0)">
                        <span><i class="fas fa-fast-backward"></i></span>
                    </a>
                </li>
                <li v-if="almacenados.current_page > 1" class="page-item">
                    <a href="" aria-label="Previous" class="page-link"
                    @click.prevent="changePage(almacenados.current_page - 1)">
                        <span><i class="fas fa-backward"></i></span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" class="page-item"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="" class="page-link"
                        @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="almacenados.current_page < almacenados.last_page" class="page-item">
                    <a href="" aria-label="Next" class="page-link"
                        @click.prevent="changePage(almacenados.current_page + 1)">
                        <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                    </a>
                </li>
                <li v-if="almacenados.current_page < almacenados.last_page-1" class="page-item">
                    <a href="" aria-label="Last" class="page-link"
                        @click.prevent="changePage(almacenados.last_page)">
                        <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="form-group row callout callout-danger border border-secondary">
    <label class="col-form-label col-form-label-sm col-md-2">Total Cajas</label>
    <div class="col-md-2">
        <input type="text" class="form-control form-control-sm" :value="totalCajas">
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