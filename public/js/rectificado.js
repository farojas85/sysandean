var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Rectificado',
        pagina:5,
        offset:4,
        busqueda:'',
        errores:[],
        rectificados:{},
        rectificado:{
            id:'',
            lote_id:'',
            lote_nombre:'',
            kilogramo_rectificado:'',
            observacion:'',
            fecha_registro:'',
            trabajador_id:'',
            estadoCrud:'nuevo'
        },
        lotes:[],
        lotes_count:0,
        total_rectificados:0,
        show_rectificados:'habilitados',
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
            return this.rectificados.current_page;
        },
        pagesNumber() {
            if (!this.rectificados.to) {
                return [];
            }
            var from = this.rectificados.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.rectificados.last_page) {
                to = this.rectificados.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
          // a computed getter
        totalKilogramoRectificado: function () {
            var suma = 0
            if(this.rectificados.data)
            {
                this.rectificados.data.forEach( rect =>{
                    suma += rect.kilogramo_rectificado
                })
            }
            return (suma.toFixed(2))
        },
        rendimientoEtapa: function() {
            var rendimiento = 0
            if(this.rectificados.data)
            {
               var suma =0
                this.rectificados.data.forEach( rect =>{
                    rect.lote.pelado_quimicos.forEach(pelado =>{
                        suma += pelado.kilogramo
                    })
                })
                rendimiento = (this.totalKilogramoRectificado/suma)*100
            }

            return rendimiento.toFixed(2)
        },
        rendimientoPrincipio: function() {
            var rendimiento = 0
            if(this.rectificados.data)
            {
                maduros = 0
                this.rectificados.data.forEach( rect =>{
                   maduros = rect.lote.maduros
                })
                rendimiento = (this.totalKilogramoRectificado/maduros)*100
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
            axios.get('rectificado-'+this.show_rectificados+'?pagina='+this.pagina+'&buscar='+this.busqueda)
            .then((respuesta) => {
                this.rectificados=respuesta.data
                this.total_rectificados = this.rectificados.total
            })
        },
        getResults(page=1){
            axios.get('rectificado-'+this.show_rectificados+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda)
            .then(response => {
                this.rectificados = response.data
                this.total_rectificados = this.rectificados.total
            });
        },
        limpiarTablas()
        {
            this.filtroPorLotes = false
            this.filtroLotes = []
            this.rectificados = {}
            this.total_rectificados = 0
        },
        todos()
        {
            this.show_rectificados = 'todos'
            this.limpiarTablas()  
            this.limpiar()
            this.getResults()
        },
        habilitados()
        {
            this.show_rectificados = 'habilitados'
            this.limpiarTablas()
            this.listar()
            this.getResults()
        },
        eliminados()
        {
            this.show_rectificados = 'eliminados'
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
            this.rectificado.id = ''
            this.rectificado.lote_id='',
            this.rectificado.lote_nombre=''
            this.rectificado.kilogramo=''
            this.rectificado.observacion=''
            this.rectificado.fecha_registro=''
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
            this.rectificado.estadoCrud = 'nuevo'
            $('#modal-rectificado').modal('show')
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
            this.rectificado.lote_id = lote.id
            this.rectificado.lote_nombre = lote.nombre
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
            this.rectificados = []
            this.total_rectificados = 0
            this.listarLotes()
        },
        obtenerRecitificadosLote(event)
        {
            this.buscarLote.lote = event.target.value
            axios.get('rectificado-por-lote',{params:this.buscarLote})
            .then(respuesta => {
                this.rectificados = respuesta.data
                this.total_rectificados = this.rectificados.total
            })
        },
        guardar()
        {
            axios.post('rectificado',this.rectificado)
            .then(respuesta =>{
                if(respuesta.data.ok == 1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-rectificado').modal('hide')
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
                let lote = respuesta.data
                this.lote.id = lote.id
                this.lote.nombre = lote.nombre
                this.lote.materia_prima_id=lote.materia_prima.id
                this.lote.materia_prima_nombre=lote.materia_prima.nombre
                this.lote.kilogramo=lote.kilogramo
                this.lote.descripcion = lote.descripcion
                this.lote.fecha_registro=lote.fecha_registro
                this.lote.maduros=lote.maduros
                this.lote.pinton=lote.pinton
                this.lote.verde=lote.verde
                this.lote.podrido=lote.podrido
                this.lote.enanas=lote.enanas
            })
        },
        mostrar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.lote.estadoCrud = 'mostrar'
            $('#modal-rectificado-mostrar').modal('show')
        },
        editar(lote)
        {
            this.limpiar()
            this.mostrarDatos(lote)
            this.lote.estadoCrud = 'editar'
            $('#modal-rectificado-title').html('Editar Lote')        
            $('#modal-rectificado').modal('show')
        },
        eliminar(id) {
            Swal.fire({
                title:"rectificados",
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
            swal.fire({
                title:"Lote",
                text:'¿Está Seguro de Restaurar la Lote?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('lote-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
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

                        }
                    })
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
                }
            }).catch((errors) => {
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
    }
})