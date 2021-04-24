var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Almacenado',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        almacenados:{},
        almacenado:{
            id:'',
            lote_id:'',
            lote_nombre:'',
            cajas:'',
            peso_caja:'',
            observacion:'',
            fecha_registro:'',
            trabajador_id:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_almacenados:0,
        show_almacenados:'habilitados',
        trabajadores:[],
        filtroPorLotes:false,
        filtroLotes:[],
        buscarLote:{
            lote:''
        },
    },
    created() {
        this.habilitados()
    },
    computed:{
        isActived() {
            return this.almacenados.current_page;
        },
        pagesNumber() {
            if (!this.almacenados.to) {
                return [];
            }
            var from = this.almacenados.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.almacenados.last_page) {
                to = this.almacenados.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
          // a computed getter
        totalCajas: function () {
            var suma = 0
            if(this.almacenados.data)
            {
                this.almacenados.data.forEach( alma =>{
                    suma += alma.cajas
                })
            }
            return (suma.toFixed(0))
        },
        rendimientoEtapa: function() {
            var rendimiento = 0
            if(this.almacenados.data)
            {
               var suma =0
               var sumacaja=0;
                this.almacenados.data.forEach( alma =>{
                    sumacaja += alma.cajas*alma.peso_caja;
                    alma.lote.envasados.forEach(envasado =>{
                        suma += envasado.kilogramo_envasado
                    })
                })
                rendimiento = (sumacaja/suma)*100
            }

            return rendimiento.toFixed(2)
        },
        rendimientoPrincipio: function() {
            var rendimiento = 0
            if(this.almacenados.data)
            {
                maduros = 0
                this.almacenados.data.forEach( alma =>{
                   maduros = alma.lote.maduros
                })
                rendimiento = ((this.totalCajas*10)/maduros)*100
            }
            return rendimiento.toFixed(2)
        }
    },
    methods:{
        cambiarPaginacion(event)
        {
            this.pagina = event.target.value
            this.listar()
            this.getResults()
        },
        listar() {
            axios.get('almacenado-'+this.show_almacenados+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.almacenados=respuesta.data
                this.total_almacenados = this.almacenados.total
            })
        },
        getResults(page=1){
            axios.get('almacenado-'+this.show_almacenados+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.almacenados = response.data
                this.total_almacenados = this.almacenados.total
            });
        },
        limpiarTablas()
        {
            this.filtroPorLotes = false
            this.filtroLotes = []
            this.almacenados = {}
            this.total_almacenados = 0
        },
        todos()
        {
            this.show_almacenados = 'todos'
            this.limpiarTablas()  
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_almacenados = 'habilitados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_almacenados = 'eliminados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        changePage(page) {
            this.almacenados.current_page = page;
            this.getResults(page)
        },
        buscar()
        {
            this.listar()
            this.getResults()
        },
        limpiar()
        {
            this.errores=[]
            this.almacenado.id = ''
            this.almacenado.lote_id='',
            this.almacenado.lote_nombre=''
            this.almacenado.kilogramo_almacenado=''
            this.almacenado.observacion=''
            this.almacenado.trabajador_id=''
            this.almacenado.fecha_registro=''
        },
        listarTrabajadores()
        {
            axios.get('trabajador-listar')
            .then(respuesta => {
                this.trabajadores = respuesta.data
            })
        },
        nuevo()
        {
            this.limpiar()
            this.almacenado.estadoCrud = 'nuevo'
            $('#modal-almacenado').modal('show')
            this.listarTrabajadores()
        },
        buscarLotes(event)
        {
            this.lotes=[]
            this.lotes_count = 0
            axios.get('lote-buscar',{params:{buscar_lote: event.target.value}})
            .then((respuesta)=>{
                this.lotes= respuesta.data
                this.lotes_count = ( this.lotes.total >0) ?  2 : 1
            })
        },
        seleccionarLote(lote)
        {
            this.almacenado.lote_id = lote.id
            this.almacenado.lote_nombre = lote.nombre
            this.lotes=[]
            this.lotes_count = 0
        },
        listarLotes()
        {
            axios.get('lote-listar')
            .then(respuesta =>{
                this.filtroLotes = respuesta.data
                this.buscarLote.lote =''
            })
        },
        porLotes()
        {
            this.filtroPorLotes = true;
            this.almacenados = []
            this.total_almacenados = 0
            this.listarLotes()
        },
        obtenerAlmacenadosLote(event)
        {
            this.buscarLote.lote = event.target.value
            axios.get('almacenado-por-lote',{params:this.buscarLote})
            .then(respuesta => {
                this.almacenados = respuesta.data
                this.total_almacenados = this.almacenados.total
            })
        },
        guardar()
        {
            axios.post('almacenado',this.almacenado)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-almacenado').modal('hide')
                    this.errores=[]
                    this.habilitados()
                }
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    //console.clear()
                }
            })
        },
        mostrarDatos(id)
        {
            axios.get('almacenado-mostrar?id='+id)
            .then(respuesta=>{                
                let rect = respuesta.data
                this.almacenado.id = rect.id
                this.almacenado.lote_id = rect.lote_id
                this.almacenado.lote_nombre=rect.lote.nombre
                this.almacenado.cajas = rect.cajas
                this.almacenado.peso_caja = rect.peso_caja
                this.almacenado.observacion = rect.observacion
                this.almacenado.fecha_registro=rect.fecha_registro
                this.almacenado.trabajador_id = rect.trabajador_id
            })
        },
        mostrar(id)
        {
            this.limpiar()
            this.mostrarDatos(id)
            this.listarTrabajadores()
            this.almacenado.estadoCrud = 'mostrar'
            $('#modal-almacenado-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.listarTrabajadores()
            this.almacenado.estadoCrud = 'editar'
            $('#modal-almacenado-title').html('Editar Lote')        
            $('#modal-almacenado').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Almacenados",
                text:'¿Está Seguro de Eliminar la Lote?',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    this.eliminarTemporal(id)
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarPermanente(id)
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarTemporal(id){
            axios.post('almacenado-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'almacenado',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.habilitados()
                        }
                    })
                }
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        eliminarPermanente(id) {
            axios.post('almacenado-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'almacenado',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        this.habilitados()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    swal.fire({
                        icon : 'error',
                        title : 'almacenado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"almacenado",
                text:'¿Está Seguro de Restaurar el almacenado?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('almacenado-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'almacenado',
                                text : response.data.mensaje,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            }).then(respuesta => {
                                if(respuesta.value) {
                                    this.habilitados()
                                }
                            })

                        }
                    })
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                            swal.fire({
                                icon : 'error',
                                title : 'almacenado',
                                text : this.errores,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            })
                        }
                    })
                }
            }).catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    swal.fire({
                        icon : 'error',
                        title : 'almacenado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})