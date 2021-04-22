var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Congelado',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        congelados:{},
        congelado:{
            id:'',
            lote_id:'',
            lote_nombre:'',
            kilogramo_congelado:'',
            observacion:'',
            fecha_registro:'',
            trabajador_id:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_congelados:0,
        show_congelados:'habilitados',
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
            return this.congelados.current_page;
        },
        pagesNumber() {
            if (!this.congelados.to) {
                return [];
            }
            var from = this.congelados.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.congelados.last_page) {
                to = this.congelados.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
          // a computed getter
        totalKilogramoCongelado: function () {
            var suma = 0
            if(this.congelados.data)
            {
                this.congelados.data.forEach( conge =>{
                    suma += conge.kilogramo_congelado
                })
            }
            return (suma.toFixed(2))
        },
        rendimientoEtapa: function() {
            var rendimiento = 0
            if(this.congelados.data)
            {
               var suma =0
                this.congelados.data.forEach( conge =>{
                    conge.lote.plaqueados.forEach(plaquea =>{
                        suma += plaquea.kilogramo_plaqueado
                    })
                })
                rendimiento = (this.totalKilogramoCongelado/suma)*100
            }

            return rendimiento.toFixed(2)
        },
        rendimientoPrincipio: function() {
            var rendimiento = 0
            if(this.congelados.data)
            {
                maduros = 0
                this.congelados.data.forEach( rect =>{
                   maduros = rect.lote.maduros
                })
                rendimiento = (this.totalKilogramoCongelado/maduros)*100
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
            axios.get('congelado-'+this.show_congelados+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.congelados=respuesta.data
                this.total_congelados = this.congelados.total
            })
        },
        getResults(page=1){
            axios.get('congelado-'+this.show_congelados+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.congelados = response.data
                this.total_congelados = this.congelados.total
            });
        },
        limpiarTablas()
        {
            this.filtroPorLotes = false
            this.filtroLotes = []
            this.congelados = {}
            this.total_congelados = 0
        },
        todos()
        {
            this.show_congelados = 'todos'
            this.limpiarTablas()  
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_congelados = 'habilitados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_congelados = 'eliminados'
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
            this.congelado.id = ''
            this.congelado.lote_id='',
            this.congelado.lote_nombre=''
            this.congelado.kilogramo_congelado=''
            this.congelado.observacion=''
            this.congelado.trabajador_id=''
            this.congelado.fecha_registro=''
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
            this.congelado.estadoCrud = 'nuevo'
            $('#modal-congelado').modal('show')
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
            this.congelado.lote_id = lote.id
            this.congelado.lote_nombre = lote.nombre
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
            this.congelados = []
            this.total_congelados = 0
            this.listarLotes()
        },
        obtenerCongeladosLote(event)
        {
            this.buscarLote.lote = event.target.value
            axios.get('congelado-por-lote',{params:this.buscarLote})
            .then(respuesta => {
                this.congelados = respuesta.data
                this.total_congelados = this.congelados.total
            })
        },
        guardar()
        {
            axios.post('congelado',this.congelado)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-congelado').modal('hide')
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
            axios.get('congelado-mostrar?id='+id)
            .then(respuesta=>{                
                let rect = respuesta.data
                this.congelado.id = rect.id
                this.congelado.lote_id = rect.lote_id
                this.congelado.lote_nombre=rect.lote.nombre
                this.congelado.kilogramo_congelado = rect.kilogramo_congelado
                this.congelado.observacion = rect.observacion
                this.congelado.fecha_registro=rect.fecha_registro
                this.congelado.trabajador_id = rect.trabajador_id
            })
        },
        mostrar(id)
        {
            this.limpiar()
            this.mostrarDatos(id)
            this.listarTrabajadores()
            this.congelado.estadoCrud = 'mostrar'
            $('#modal-congelado-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.listarTrabajadores()
            this.congelado.estadoCrud = 'editar'
            $('#modal-congelado-title').html('Editar Lote')        
            $('#modal-congelado').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Congelados",
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
            axios.post('congelado-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Congelado',
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
            axios.post('congelado-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Congelado',
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
                        title : 'Congelado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"Congelado",
                text:'¿Está Seguro de Restaurar el congelado?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('congelado-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'congelado',
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
                                title : 'Congelado',
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
                        title : 'Congelado',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})