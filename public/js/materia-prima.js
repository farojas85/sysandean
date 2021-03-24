var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Materia Prima',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        materiaPrimas:{},
        materiaPrima:{
            id:'',
            nombre:'',
            descripcion:'',
            estadoCrud:'nuevo'
        },
        total_materias:0,
        show_materias:'habilitados'
    },
    created() {
        this.habilitados()
    },
    computed:{
        isActivate() {
            return this.materiaPrimas.current_page;
        },
        pagesNumber() {
            if (!this.materiaPrimas.to) {
                return [];
            }
            var from = this.materiaPrimas.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.materiaPrimas.last_page) {
                to = this.materiaPrimas.last_page;
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
            axios.get('materia-prima-'+this.show_materias+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.materiaPrimas=respuesta.data
                this.total_materias = this.materiaPrimas.total
            })
        },
        getResults(page=1){
            axios.get('materia-prima-'+this.show_materias+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.materiaPrimas = response.data
                this.total_materias = this.materiaPrimas.total
            });
        },
        todos()
        {
            this.show_materias = 'todos'
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_materias = 'habilitados'
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_materias = 'eliminados'
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
            this.materiaPrima.id = ''
            this.materiaPrima.nombre = ''
            this.materiaPrima.descripcion = ''
        },
        nuevo()
        {
            this.limpiar()
            this.materiaPrima.estadoCrud = 'nuevo'
            $('#modal-materia-prima').modal('show')
        },

        guardar()
        {
            axios.post('materia-prima',this.materiaPrima)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-materia-prima').modal('hide')
                    this.errores=[]
                    this.habilitados()
                }
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        mostrarDatos(materiaPrima)
        {
            axios.get('materia-prima-mostrar?id='+materiaPrima)
            .then(respuesta=>{                
                let materia = respuesta.data
                this.materiaPrima.id = materia.id
                this.materiaPrima.nombre = materia.nombre
                this.materiaPrima.descripcion = materia.descripcion    
            })
        },
        mostrar(materiaPrima)
        {
            this.limpiar()
            this.mostrarDatos(materiaPrima)
            this.materiaPrima.estadoCrud = 'mostrar'
            $('#modal-materia-prima-mostrar').modal('show')
        },
        editar(materiaPrima)
        {
            this.limpiar()
            this.mostrarDatos(materiaPrima)
            this.materiaPrima.estadoCrud = 'editar'
            $('#modal-materia-prima-title').html('Editar Materia Prima')        
            $('#modal-materia-prima').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"Materia Primas",
                text:'¿Está Seguro de Eliminar la Materia Prima?',
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
            axios.post('materia-prima-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Materia Prima',
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
            axios.post('materia-prima-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Materia Prima',
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
                        title : 'Materia Prima',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"Materia Prima",
                text:'¿Está Seguro de Restaurar la Materia Prima?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('materia-prima-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Materia Prima',
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
                                title : 'Materia Prima',
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
                        title : 'Materia Prima',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})