var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Lote',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        lotes:{},
        lote:{
            id:'',
            nombre:'',
            materia_prima_id:'',
            materia_prima_nombre:'',
            kilogramo:'',
            descripcion:'',
            fecha_registro:'',
            maduros:'',
            pinton:'',
            verde:'',
            podrido:'',
            enanas:'',
            estadoCrud:'nuevo'
        },
        materiaPrimas:[],
        materiaPrimas_count:0,
        total_lotes:0,
        show_lotes:'habilitados'
    },
    created() {
        this.habilitados()
    },
    computed:{
        isActivate() {
            return this.lotes.current_page;
        },
        pagesNumber() {
            if (!this.lotes.to) {
                return [];
            }
            var from = this.lotes.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.lotes.last_page) {
                to = this.lotes.last_page;
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
            axios.get('lote-'+this.show_lotes+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.lotes=respuesta.data
                this.total_lotes = this.lotes.total
            })
        },
        getResults(page=1){
            axios.get('lote-'+this.show_lotes+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.lotes = response.data
                this.total_lotes = this.lotes.total
            });
        },
        todos()
        {
            this.show_lotes = 'todos'
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_lotes = 'habilitados'
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_lotes = 'eliminados'
            this.listar()
            this.getResults()
        },
        changePage(page) {
            this.usuarios.current_page = page;
            this.getResults(page)
        },
        buscar()
        {

        },
        limpiar()
        {
            this.errores=[]
            this.lote.id = ''
            this.lote.nombre=''
            this.lote.materia_prima_id='',
            this.lote.materia_prima_nombre=''
            this.lote.kilogramo=''
            this.lote.descripcion=''
            this.lote.fecha_registro=''
            this.lote.maduros=''
            this.lote.pinton=''
            this.lote.verde=''
            this.lote.podrido=''
            this.lote.enanas=''
        },
        nuevo()
        {
            this.limpiar()
            this.lote.estadoCrud = 'nuevo'
            $('#modal-lote').modal('show')
        },
        buscarMateriaPrimas(event)
        {
            this.materiaPrimas=[]
            this.materiaPrimas_count = 0
            axios.get('materia-prima-buscar',{params:{buscar_materia: event.target.value}})
            .then((respuesta)=>{
                this.materiaPrimas= respuesta.data
                this.materiaPrimas_count = ( this.materiaPrimas.total >0) ?  2 : 1
            })
        },
        seleccionarMateriaPrima(materia)
        {
            this.lote.materia_prima_id = materia.id
            this.lote.materia_prima_nombre = materia.nombre
            this.materiaPrimas=[]
            this.materiaPrimas_count = 0
        },
        guardar()
        {
            axios.post('lote',this.lote)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-lote').modal('hide')
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
        mostrarDatos(lote)
        {
            axios.get('lote-mostrar?id='+lote)
            .then(respuesta=>{                
                let materia = respuesta.data
                this.lote.id = materia.id
                this.lote.nombre = materia.nombre
                this.lote.descripcion = materia.descripcion    
            })
        },
        mostrar(lote)
        {
            // this.limpiar()
            // this.mostrarDatos(lote)
            // this.lote.estadoCrud = 'mostrar'
            // $('#modal-lote-mostrar').modal('show')
        },
        editar(lote)
        {
            // this.limpiar()
            // this.mostrarDatos(lote)
            // this.lote.estadoCrud = 'editar'
            // $('#modal-lote-title').html('Editar Lote')        
            // $('#modal-lote').modal('show')
        },
        eliminar(id) {
            // Swal.fire({
            //     title:"Lotes",
            //     text:'¿Está Seguro de Eliminar la Lote?',
            //     icon:"question",
            //     showCancelButton: true,
            //     confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
            //     confirmButtonColor:"#6610f2",
            //     cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
            //     cancelButtonColor:"#e3342f"
            // }).then( (response) => {
            //     if(response.value) {
            //         this.eliminarTemporal(id)
            //     }
            //     else if( response.dismiss === swal.DismissReason.cancel) {
            //        this.eliminarPermanente(id)
            //     }
            // }).catch(error => {
            //     swal.showValidationError(
            //         `Ocurrió un Error: ${error.response.status}`
            //     )
            // })
        },
        eliminarTemporal(id){
            axios.post('lote-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Lote',
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
            axios.post('lote-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Lote',
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
            // swal.fire({
            //     title:"Lote",
            //     text:'¿Está Seguro de Restaurar la Lote?"',
            //     icon:"question",
            //     showCancelButton: true,
            //     confirmButtonText:"Si",
            //     confirmButtonColor:"#28a745",
            //     cancelButtonText:"No",
            //     cancelButtonColor:"#dc3545"
            // }).then( (response) => {
            //     if(response.value) {
            //         axios.post('lote-restaurar',{id:id})
            //         .then((response) => {
            //             if(response.data.ok==1)
            //             {
            //                 swal.fire({
            //                     icon : 'success',
            //                     title : 'Lote',
            //                     text : response.data.mensaje,
            //                     confirmButtonText: 'Aceptar',
            //                     confirmButtonColor:"#1abc9c",
            //                 }).then(respuesta => {
            //                     if(respuesta.value) {
            //                         this.habilitados()
            //                     }
            //                 })

            //             }
            //         })
            //         .catch((errors) => {
            //             if(response = errors.response) {
            //                 this.errores = response.data.errors
            //                 swal.fire({
            //                     icon : 'error',
            //                     title : 'Lote',
            //                     text : this.errores,
            //                     confirmButtonText: 'Aceptar',
            //                     confirmButtonColor:"#1abc9c",
            //                 })
            //             }
            //         })
            //     }
            // }).catch((errors) => {
            //     if(response = errors.response) {
            //         this.errores = response.data.errors
            //         swal.fire({
            //             icon : 'error',
            //             title : 'Lote',
            //             text : this.errores,
            //             confirmButtonText: 'Aceptar',
            //             confirmButtonColor:"#1abc9c",
            //         })
            //     }
            // })
        },
    }
})