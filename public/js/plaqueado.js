var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Plaqueado',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        plaqueados:{},
        plaqueado:{
            id:'',
            lote_id:'',
            lote_nombre:'',
            kilogramo_plaqueado:'',
            observacion:'',
            fecha_registro:'',
            trabajador_id:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_plaqueados:0,
        show_plaqueados:'habilitados',
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
            return this.plaqueados.current_page;
        },
        pagesNumber() {
            if (!this.plaqueados.to) {
                return [];
            }
            var from = this.plaqueados.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.plaqueados.last_page) {
                to = this.plaqueados.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
          // a computed getter
        totalKilogramoPlaqueado: function () {
            var suma = 0
            if(this.plaqueados.data)
            {
                this.plaqueados.data.forEach( rect =>{
                    suma += rect.kilogramo_plaqueado
                })
            }
            return (suma.toFixed(2))
        },
        rendimientoEtapa: function() {
            var rendimiento = 0
            if(this.plaqueados.data)
            {
               var suma =0
                this.plaqueados.data.forEach( plaq =>{
                    plaq.lote.rectificados.forEach(rectifi =>{
                        suma += rectifi.kilogramo_rectificado
                    })
                })
                rendimiento = (this.totalKilogramoPlaqueado/suma)*100
            }

            return rendimiento.toFixed(2)
        },
        rendimientoPrincipio: function() {
            var rendimiento = 0
            if(this.plaqueados.data)
            {
                maduros = 0
                this.plaqueados.data.forEach( rect =>{
                   maduros = rect.lote.maduros
                })
                rendimiento = (this.totalKilogramoPlaqueado/maduros)*100
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
            axios.get('plaqueado-'+this.show_plaqueados+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.plaqueados=respuesta.data
                this.total_plaqueados = this.plaqueados.total
            })
        },
        getResults(page=1){
            axios.get('plaqueado-'+this.show_plaqueados+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.plaqueados = response.data
                this.total_plaqueados = this.plaqueados.total
            });
        },
        limpiarTablas()
        {
            this.filtroPorLotes = false
            this.filtroLotes = []
            this.plaqueados = {}
            this.total_plaqueados = 0
        },
        todos()
        {
            this.show_plaqueados = 'todos'
            this.limpiarTablas()  
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_plaqueados = 'habilitados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_plaqueados = 'eliminados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        changePage(page) {
            this.usuarios.current_page = page;
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
            this.plaqueado.id = ''
            this.plaqueado.lote_id='',
            this.plaqueado.lote_nombre=''
            this.plaqueado.kilogramo_plaqueado=''
            this.plaqueado.observacion=''
            this.plaqueado.trabajador_id=''
            this.plaqueado.fecha_registro=''
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
            this.plaqueado.estadoCrud = 'nuevo'
            $('#modal-plaqueado').modal('show')
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
            this.plaqueado.lote_id = lote.id
            this.plaqueado.lote_nombre = lote.nombre
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
            this.plaqueados = []
            this.total_plaqueados = 0
            this.listarLotes()
        },
        obtenerPlaqueadosLote(event)
        {
            this.buscarLote.lote = event.target.value
            axios.get('plaqueado-por-lote',{params:this.buscarLote})
            .then(respuesta => {
                this.plaqueados = respuesta.data
                this.total_plaqueados = this.plaqueados.total
            })
        },
        guardar()
        {
            axios.post('plaqueado',this.plaqueado)
            .then(respuesta =>{
                console.log(respuesta.data)
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-plaqueado').modal('hide')
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
            axios.get('plaqueado-mostrar?id='+id)
            .then(respuesta=>{                
                let rect = respuesta.data
                this.plaqueado.id = rect.id
                this.plaqueado.lote_id = rect.lote_id
                this.plaqueado.lote_nombre=rect.lote.nombre
                this.plaqueado.kilogramo_plaqueado = rect.kilogramo_plaqueado
                this.plaqueado.observacion = rect.observacion
                this.plaqueado.fecha_registro=rect.fecha_registro
                this.plaqueado.trabajador_id = rect.trabajador_id
            })
        },
        mostrar(id)
        {
            this.limpiar()
            this.mostrarDatos(id)
            this.listarTrabajadores()
            this.plaqueado.estadoCrud = 'mostrar'
            $('#modal-plaqueado-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.listarTrabajadores()
            this.plaqueado.estadoCrud = 'editar'
            $('#modal-plaqueado-title').html('Editar Lote')        
            $('#modal-plaqueado').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Plaqueados",
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
            axios.post('plaqueado-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Plaqueado',
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
            axios.post('plaqueado-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Plaqueado',
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
                        title : 'Plaqueado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"Plaqueado",
                text:'¿Está Seguro de Restaurar el Plaqueado?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('plaqueado-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Plaqueado',
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
                                title : 'Plaqueado',
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
                        title : 'Plaqueado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})