var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Envasado',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        envasados:{},
        envasado:{
            id:'',
            lote_id:'',
            lote_nombre:'',
            kilogramo_envasado:'',
            observacion:'',
            fecha_registro:'',
            trabajador_id:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_envasados:0,
        show_envasados:'habilitados',
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
            return this.envasados.current_page;
        },
        pagesNumber() {
            if (!this.envasados.to) {
                return [];
            }
            var from = this.envasados.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.envasados.last_page) {
                to = this.envasados.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
          // a computed getter
        totalKilogramoEnvasado: function () {
            var suma = 0
            if(this.envasados.data)
            {
                this.envasados.data.forEach( conge =>{
                    suma += conge.kilogramo_envasado
                })
            }
            return (suma.toFixed(2))
        },
        rendimientoEtapa: function() {
            var rendimiento = 0
            if(this.envasados.data)
            {
               var suma =0
                this.envasados.data.forEach( conge =>{
                    conge.lote.congelados.forEach(plaquea =>{
                        suma += plaquea.kilogramo_congelado
                    })
                })
                rendimiento = (this.totalKilogramoEnvasado/suma)*100
            }

            return rendimiento.toFixed(2)
        },
        rendimientoPrincipio: function() {
            var rendimiento = 0
            if(this.envasados.data)
            {
                maduros = 0
                this.envasados.data.forEach( rect =>{
                   maduros = rect.lote.maduros
                })
                rendimiento = (this.totalKilogramoEnvasado/maduros)*100
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
            axios.get('envasado-'+this.show_envasados+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.envasados=respuesta.data
                this.total_envasados = this.envasados.total
            })
        },
        getResults(page=1){
            axios.get('envasado-'+this.show_envasados+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.envasados = response.data
                this.total_envasados = this.envasados.total
            });
        },
        limpiarTablas()
        {
            this.filtroPorLotes = false
            this.filtroLotes = []
            this.envasados = {}
            this.total_envasados = 0
        },
        todos()
        {
            this.show_envasados = 'todos'
            this.limpiarTablas()  
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_envasados = 'habilitados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_envasados = 'eliminados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        changePage(page) {
            this.envasados.current_page = page;
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
            this.envasado.id = ''
            this.envasado.lote_id='',
            this.envasado.lote_nombre=''
            this.envasado.kilogramo_envasado=''
            this.envasado.observacion=''
            this.envasado.trabajador_id=''
            this.envasado.fecha_registro=''
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
            this.envasado.estadoCrud = 'nuevo'
            $('#modal-envasado').modal('show')
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
            this.envasado.lote_id = lote.id
            this.envasado.lote_nombre = lote.nombre
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
            this.envasados = []
            this.total_envasados = 0
            this.listarLotes()
        },
        obtenerEnvasadosLote(event)
        {
            this.buscarLote.lote = event.target.value
            axios.get('envasado-por-lote',{params:this.buscarLote})
            .then(respuesta => {
                this.envasados = respuesta.data
                this.total_envasados = this.envasados.total
            })
        },
        guardar()
        {
            axios.post('envasado',this.envasado)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-envasado').modal('hide')
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
            axios.get('envasado-mostrar?id='+id)
            .then(respuesta=>{                
                let rect = respuesta.data
                this.envasado.id = rect.id
                this.envasado.lote_id = rect.lote_id
                this.envasado.lote_nombre=rect.lote.nombre
                this.envasado.kilogramo_envasado = rect.kilogramo_envasado
                this.envasado.observacion = rect.observacion
                this.envasado.fecha_registro=rect.fecha_registro
                this.envasado.trabajador_id = rect.trabajador_id
            })
        },
        mostrar(id)
        {
            this.limpiar()
            this.mostrarDatos(id)
            this.listarTrabajadores()
            this.envasado.estadoCrud = 'mostrar'
            $('#modal-envasado-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.listarTrabajadores()
            this.envasado.estadoCrud = 'editar'
            $('#modal-envasado-title').html('Editar Lote')        
            $('#modal-envasado').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Envasados",
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
            axios.post('envasado-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Envasado',
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
            axios.post('envasado-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Envasado',
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
                        title : 'Envasado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"envasado",
                text:'¿Está Seguro de Restaurar el Envasado?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('envasado-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Envasado',
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
                                title : 'Envasado',
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
                        title : 'Envasado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})