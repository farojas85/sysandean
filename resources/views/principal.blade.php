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
                <h3>150</h3>

                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
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
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $trabajadores_count }}</h3>

                <p>Trabajadores</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="sistema" class="small-box-footer">M&aacute;s info...<i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
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
    </div>
    {{-- <div id="chart" style="height: 300px;"></div> --}}

    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-2">
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
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 position-relative">
        <canvas id="lotes-chart"></canvas>
    </div>
    <div class="col-md-2"></div>
</div>
<!-- /.row -->
@endsection

@section('scripties')
<script>
    new Vue({
        el: '#wrapper',
        data: {
            lotes:[],
            fechaActual: '',
            lote: '',
            fecha:'',
            fechas: [],
            graficaLotes:{
                cantidad :[],
                detalles:['Maduro','Pintón','Verde','Podrido','Pequeño'],
            },
            salesChart:null,
            pieLotesChart:null,
        },
        created() {
            this.obtenerLotes()
            
            //this.ultimoDia()
            //this.listarUltimasMatriculas()
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
                axios.get('lote-listar-datos',{ 
                    params:{ lote:this.lote, fecha:this.fecha}
                }).then(respuesta => {
                    this.graficaLotes.cantidad = respuesta.data.cantidades
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
                if(this.pieLotesChart)
                {
                    this.pieLotesChart.clear()
                    this.pieLotesChart.destroy()
                }

                var $pieChart = $('#lotes-chart')

                var config = {
                    type: 'pie',
                    data: {
                        datasets:[{
                            data: this.graficaLotes.cantidad,
                            backgroundColor:[
                                '#3c8dbc','#f56954', '#00a65a', '#f39c12', '#00c0ef',
                            ],
                            label: 'Ventas',
                            datalabels: {
                                labels: {
                                    title: {
                                        color: 'white'
                                    },
                                },
                                font: {
                                    weight: 'bold'
                                },
                            }
                        }],
                        labels:this.graficaLotes.detalles
                    },
                    options: {
                        responsive: true,
                        legend:{
                            position: 'bottom'
                        },
                    }
                }

                this.pieLotesChart = new Chart($pieChart,config)
            },
        }
    })

</script>
@endsection