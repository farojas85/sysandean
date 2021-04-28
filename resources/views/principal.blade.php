@extends('layouts.master')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $lotes_count}}</h3>

                <p>Lote(s)</p>
            </div>
            <div class="icon">
                <i class="fas fa-clone"></i>
            </div>
            <a href="lote" class="small-box-footer">M&aacute;s Info... <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    {{-- <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> --}}
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $trabajadores_count }}</h3>

                <p>Trabajador(es)</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="sistema" class="small-box-footer">M&aacute;s info... <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    {{-- <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> --}}
    {{-- <div id="chart" style="height: 300px;"></div> --}}

    <!-- ./col -->
</div>
{{-- <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-2 mb-4">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">LOTE</span>
            </div>
            <select v-model="lote" id="lote" >
                <option value="">-Seleccionar-</option>
                <option v-for="lote in lotes" :value="lote.id" v-text="lote.nombre"></option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text font-weight-bold">Fecha</span>
            </div>
             <input type="date" v-model="fecha" class="form-control" @change="obtenerDatosLotes">
        </div>
    </div>
    <div class="col-md-2"></div>
</div> --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Lotes por Fecha
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text font-weight-bold">LOTE</span>
                                    </div>
                                    <select v-model="lote" id="lote" >
                                        <option value="">-Seleccionar-</option>
                                        <option v-for="lote in lotes" :value="lote.id" v-text="lote.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text font-weight-bold">Fecha</span>
                                    </div>
                                     <input type="date" v-model="fecha" class="form-control" @change="obtenerDatosLotes">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="charts">
                                {{-- <canvas id="lotes-chart" width="200" height="200"></canvas> --}}
                                <apexchart type="pie" :series="graficaLotes.series" 
                                    :options="graficaLotes.chartOptions"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Total de Datos</strong>
                        </p>
                        <h4 class="small font-weight-bold">Maduro 
                            <span class="float-right">@{{ graficaLotes.maduro[0] }} / @{{ graficaLotes.total }}</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                :style="{width:graficaLotes.maduro[1]+'%'}" 
                                :aria-valuenow="graficaLotes.maduro[0]" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Pint&oacute;n 
                            <span class="float-right">@{{ graficaLotes.pinton[0] }} / @{{ graficaLotes.total }}</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-teal" role="progressbar" :style="{width:graficaLotes.pinton[1]+'%'}" :aria-valuenow="graficaLotes.pinton[0]" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Verde 
                            <span class="float-right">@{{ graficaLotes.verde[0] }} / @{{ graficaLotes.total }}</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-yellow" role="progressbar" :style="{width:graficaLotes.verde[1]+'%'}" :aria-valuenow="graficaLotes.verde[0]" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Podrido 
                            <span class="float-right">@{{ graficaLotes.podrido[0] }} / @{{ graficaLotes.total }}</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-pink" role="progressbar" :style="{width:graficaLotes.podrido[1]+'%'}" :aria-valuenow="graficaLotes.podrido[0]" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Peque&ntilde;o 
                            <span class="float-right">@{{ graficaLotes.enana[0] }} / @{{ graficaLotes.total }}</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-indigo" role="progressbar" :style="{width:graficaLotes.enana[1]+'%'}" :aria-valuenow="graficaLotes.enana[0]" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bars mr-1"></i>
                    Ranking Rectificado
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <rectificado-chart type="bar" :series="graficaRectificado.series" 
                            :options="graficaRectificado.chartOptions"></rectificado-chart>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bars mr-1"></i>
                    Ranking Plaqueado
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <plaqueado-chart type="bar" :series="graficaPlaqueado.series" 
                            :options="graficaPlaqueado.chartOptions"></plaqueado-chart>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bars mr-1"></i>
                    Ranking Congelados
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <congelado-chart type="bar" :series="graficaCongelado.series" 
                            :options="graficaCongelado.chartOptions"></congelado-chart>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bars mr-1"></i>
                    Ranking Envasados
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <envasado-chart type="bar" :series="graficaEnvasado.series" 
                            :options="graficaEnvasado.chartOptions"></envasado-chart>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bars mr-1"></i>
                    Ranking Almacenados
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <almacenado-chart type="bar" :series="graficaAlmacenado.series" 
                            :options="graficaAlmacenado.chartOptions"></almacenado-chart>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection

@section('scripties')
<script>
    new Vue({
        el: '#wrapper',
        components:{
            apexchart:VueApexCharts,
            RectificadoChart:VueApexCharts,
            PlaqueadoChart:VueApexCharts,
            CongeladoChart:VueApexCharts,
            EnvasadoChart:VueApexCharts,
            AlmacenadoChart:VueApexCharts
        },
        data: {
            lotes:[],
            fechaActual: '',
            lote: '',
            fecha:'',
            fechas: [],
            graficaLotes:{
                lote:'',
                fecha:'',
                series:[],
                maduro:[],
                pinton:[],
                verde:[],
                podrido:[],
                enana:[],
                total:0,
                chartOptions:{}
            },
            graficaRectificado:{
                series:[],
                labels:[],
                colores:[],
                chartOptions:{},
            },
            graficaPlaqueado:{
                series:[],
                labels:[],
                colores:[],
                chartOptions:{},
            },
            graficaCongelado:{
                series:[],
                labels:[],
                colores:[],
                chartOptions:{},
            },
            graficaEnvasado:{
                series:[],
                labels:[],
                colores:[],
                chartOptions:{},
            },
            graficaAlmacenado:{
                series:[],
                labels:[],
                colores:[],
                chartOptions:{},
            },
        },
        created() {
            this.obtenerLotes()
            this.obtenerRankingRectificados()
            this.obtenerRankingPlaqueados()
            this.obtenerRankingCongelados()
            this.obtenerRankingEnvasados()
            this.obtenerRankingAlmacenados()
        },
        methods: {
            obtenerLotes()
            {
                axios.get('lote-listar')
                .then(respuesta => {
                    this.lotes = respuesta.data
                    this.lote =1
                    this.obtenerFechaPorLote()
                    
                })
            },
            obtenerFechaPorLote()
            {
                axios.get('lote-listar-fecha',{params:{lote:this.lote}})
                .then(respuesta => {
                    this.fecha = respuesta.data.fecha_registro
                    this.obtenerDatosLotes()
                })
            },
            obtenerDatosLotes()
            {

                this.graficaLotes.cantidad = []
                this.graficaLotes.total = 0
                this.graficaLotes.maduro=[]
                this.graficaLotes.pinton=[]
                this.graficaLotes.verde=[]
                this.graficaLotes.podrido=[]
                this.graficaLotes.enana=[]
                $('.progress-bar').css('width','0%')

                axios.get('lote-listar-datos',{ 
                    params:{ lote:this.lote, fecha:this.fecha}
                }).then(respuesta => {
                    this.graficaLotes.cantidad = respuesta.data.cantidades
                    this.graficaLotes.series = respuesta.data.cantidades
                    this.graficaLotes.lote = respuesta.data.lote_nombre
                    this.graficaLotes.fecha = respuesta.data.fecha

                    this.graficaLotes.series.forEach(serie =>{
                        this.graficaLotes.total = parseFloat(this.graficaLotes.total)  + parseFloat(serie)
                    })

                    this.graficaLotes.maduro[0] = this.graficaLotes.series[0]
                    this.graficaLotes.maduro[1] = ((parseFloat(this.graficaLotes.series[0]) / parseFloat(this.graficaLotes.total)*100)).toFixed(1)
                    this.graficaLotes.pinton[0] = this.graficaLotes.series[1]
                    this.graficaLotes.pinton[1] = ((parseFloat(this.graficaLotes.series[1]) / parseFloat(this.graficaLotes.total)*100)).toFixed(1)
                    this.graficaLotes.verde[0] = this.graficaLotes.series[2]
                    this.graficaLotes.verde[1] = ((parseFloat(this.graficaLotes.series[2]) / parseFloat(this.graficaLotes.total)*100)).toFixed(1)
                    this.graficaLotes.podrido[0] = this.graficaLotes.series[3]
                    this.graficaLotes.podrido[1] = ((parseFloat(this.graficaLotes.series[3]) / parseFloat(this.graficaLotes.total)*100)).toFixed(1)
                    this.graficaLotes.enana[0] = this.graficaLotes.series[4]
                    this.graficaLotes.enana[1] = ((parseFloat(this.graficaLotes.series[4]) / parseFloat(this.graficaLotes.total)*100)).toFixed(1)

                    this.graficarLotesAhora()
                })
            },
            randomColors() {
                var r = Math.floor(Math.random() * 255)
                var g = Math.floor(Math.random() * 255)
                var b = Math.floor(Math.random() * 255)
                return "rgb(" + r + "," + g + "," + b + ")"
            },
            graficarLotesAhora() {

                this.graficaLotes.chartOptions = {
                    chart: {
                        height: 380,
                        type: 'pie',
                    },
                    labels: ['Maduro','Pintón','Verde','Podrido','Pequeño'],
                    title: {
                        text: this.graficaLotes.lote+' - '+this.graficaLotes.fecha,
                        align: 'center'
                    },
                    subtitle: {
                        text: 'Ventas',
                        align: 'center',
                    },
                    legend: {
                        position: 'bottom'
                    },
                }
            },
            obtenerRankingRectificados()
            {
                axios.get('ranking-rectificado')
                .then(respuesta =>{
                    let rectificado = respuesta.data
                    this.graficaRectificado.colores=[]
                    rectificado.labels.forEach(recti => {
                        this.graficaRectificado.colores.push('#'+Math.floor(Math.random()*16777215).toString(16))
                    })
                    this.graficaRectificado.series = [ { data : rectificado.series }] 
                    this.graficaRectificado.chartOptions = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                position: 'bottom'
                                },
                            }
                        },
                        colors:this.graficaRectificado.colores,
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: {
                                colors: ['#fff']
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: rectificado.labels,
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        title: {
                            text: 'Ranking de Rectificados por Trabajador',
                            align: 'center',
                            floating: true
                        },
                        tooltip: {
                            theme: 'dark',
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return ''
                                    }
                                }
                            }
                        }
                    }                   
                })
            },
            obtenerRankingPlaqueados()
            {
                axios.get('ranking-rectificado')
                .then(respuesta =>{
                    let plaqueado = respuesta.data
                    this.graficaPlaqueado.colores=[]
                    plaqueado.labels.forEach(recti => {
                        this.graficaPlaqueado.colores.push('#'+Math.floor(Math.random()*16777215).toString(16))
                    })
                    this.graficaPlaqueado.series = [ { data : plaqueado.series }] 
                    this.graficaPlaqueado.chartOptions = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                position: 'bottom'
                                },
                            }
                        },
                        colors:this.graficaPlaqueado.colores,
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: {
                                colors: ['#fff']
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: plaqueado.labels,
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        title: {
                            text: 'Ranking de Plaqueados por Trabajador',
                            align: 'center',
                            floating: true
                        },
                        tooltip: {
                            theme: 'dark',
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return ''
                                    }
                                }
                            }
                        }
                    }                   
                })
            },
            obtenerRankingCongelados()
            {
                axios.get('ranking-congelado')
                .then(respuesta =>{
                    let congelado = respuesta.data
                    this.graficaCongelado.colores=[]
                    congelado.labels.forEach(recti => {
                        this.graficaCongelado.colores.push('#'+Math.floor(Math.random()*16777215).toString(16))
                    })
                    this.graficaCongelado.series = [ { data : congelado.series }] 
                    this.graficaCongelado.chartOptions = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                position: 'bottom'
                                },
                            }
                        },
                        colors:this.graficaCongelado.colores,
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: {
                                colors: ['#fff']
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: congelado.labels,
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        title: {
                            text: 'Ranking de Congelados por Trabajador',
                            align: 'center',
                            floating: true
                        },
                        tooltip: {
                            theme: 'dark',
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return ''
                                    }
                                }
                            }
                        }
                    }                   
                })
            },
            obtenerRankingEnvasados()
            {
                axios.get('ranking-envasado')
                .then(respuesta =>{
                    let envasado = respuesta.data
                    this.graficaEnvasado.colores=[]
                    envasado.labels.forEach(recti => {
                        this.graficaEnvasado.colores.push('#'+Math.floor(Math.random()*16777215).toString(16))
                    })
                    this.graficaEnvasado.series = [ { data : envasado.series }] 
                    this.graficaEnvasado.chartOptions = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                position: 'bottom'
                                },
                            }
                        },
                        colors:this.graficaEnvasado.colores,
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: {
                                colors: ['#fff']
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: envasado.labels,
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        title: {
                            text: 'Ranking de Envasados por Trabajador',
                            align: 'center',
                            floating: true
                        },
                        tooltip: {
                            theme: 'dark',
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return ''
                                    }
                                }
                            }
                        }
                    }                   
                })
            },
            obtenerRankingAlmacenados()
            {
                axios.get('ranking-almacenado')
                .then(respuesta =>{
                    let almacenado = respuesta.data
                    this.graficaAlmacenado.colores=[]
                    almacenado.labels.forEach(recti => {
                        this.graficaAlmacenado.colores.push('#'+Math.floor(Math.random()*16777215).toString(16))
                    })
                    this.graficaAlmacenado.series = [ { data : almacenado.series }] 
                    this.graficaAlmacenado.chartOptions = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                position: 'bottom'
                                },
                            }
                        },
                        colors:this.graficaAlmacenado.colores,
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: {
                                colors: ['#fff']
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: almacenado.labels,
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        title: {
                            text: 'Ranking de Almacenados por Trabajador',
                            align: 'center',
                            floating: true
                        },
                        tooltip: {
                            theme: 'dark',
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return ''
                                    }
                                }
                            }
                        }
                    }                   
                })
            }
        }
    })

</script>
@endsection