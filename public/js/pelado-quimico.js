var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Pelado Químico',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        peladoQuimicos:{},
        peladoQuimico:{
            id:'',
            nombre:'',
            lote_id:'',
            lote_nombre:'',
            kilogramo:'',
            fecha_registro:'',
            observacion:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_pelado:0,
        show_pelado:'habilitados'
    },
    created() {
        this.habilitados()
    },
    computed:{
        isActivate() {
            return this.peladoQuimicos.current_page;
        },
        pagesNumber() {
            if (!this.peladoQuimicos.to) {
                return [];
            }
            var from = this.peladoQuimicos.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.peladoQuimicos.last_page) {
                to = this.peladoQuimicos.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
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
            axios.get('pelado-quimico-'+this.show_pelado+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.peladoQuimicos=respuesta.data
                this.total_pelado = this.peladoQuimicos.total
            })
        },
        getResults(page=1){
            axios.get('pelado-quimico-'+this.show_pelado+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.peladoQuimicos = response.data
                this.total_pelado = this.peladoQuimicos.total
            });
        },
        todos()
        {
            this.show_pelado = 'todos'
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_pelado = 'habilitados'
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_pelado = 'eliminados'
            this.listar()
            this.getResults()
        },
        changePage(page) {
            this.peladoQuimicos.current_page = page;
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
            this.peladoQuimico.id = ''
            this.peladoQuimico.lote_id='',
            this.peladoQuimico.lote_nombre=''
            this.peladoQuimico.kilogramo=''
            this.peladoQuimico.observacion=''
            this.peladoQuimico.fecha_registro=''
        },
        nuevo()
        {
            this.limpiar()
            this.peladoQuimico.estadoCrud = 'nuevo'
            $('#modal-pelado-quimico').modal('show')
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
            this.peladoQuimico.lote_id = lote.id
            this.peladoQuimico.lote_nombre = lote.nombre
            this.lotes=[]
            this.lotes_count = 0
        },
        guardar()
        {
            axios.post('pelado-quimico',this.peladoQuimico)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-pelado-quimico').modal('hide')
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
        mostrarDatos(peladoQuimico)
        {
            axios.get('pelado-quimico-mostrar?id='+peladoQuimico)
            .then(respuesta=>{                
                let pelado = respuesta.data
                this.peladoQuimico.id = pelado.id
                this.peladoQuimico.lote_id=pelado.lote.id
                this.peladoQuimico.lote_nombre=pelado.lote.nombre
                this.peladoQuimico.kilogramo=pelado.kilogramo
                this.peladoQuimico.observacion = pelado.observacion
                this.peladoQuimico.fecha_registro=pelado.fecha_registro
            })
        },
        mostrar(pelado)
        {
            this.limpiar()
            this.mostrarDatos(pelado)
            this.peladoQuimico.estadoCrud = 'mostrar'
            $('#modal-pelado-quimico-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.peladoQuimico.estadoCrud = 'editar'
            $('#modal-pelado-quimico-title').html('Editar Pelado Químico')        
            $('#modal-pelado-quimico').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Pelado Químico",
                text:'¿Está Seguro de Eliminar el pelado Químico?',
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
            axios.post('pelado-quimico-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Pelado Químico',
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
            axios.post('pelado-quimico-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Pelado Químico',
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
                        title : 'Lote',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"Pelado Químico",
                text:'¿Está Seguro de Restaurar el Pelado Químico?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('pelado-quimico-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Pelado Químico',
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
                                title : 'Pelado Químico',
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
                        title : 'Pelado Químico',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})