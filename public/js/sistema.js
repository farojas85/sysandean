var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Usuarios',
        offset:4,
        errores:[],
        pagina_usuario:5,
        buscar_usuario:'',
        rolesLista:[],
        usuarios:{},
        total_usuarios:0,
        show_usuarios:'habilitados',
        usuario:{
            id:'',
            nombre:'',
            usuario:'',
            email:'',
            password:'',
            estado:'',
            role_id:'',
            estadoCrud:'nuevo'
        }
    },
    created(){
        this.cambiarVista('Usuarios')
    },
    computed:{
        isActivedUsuario() {
            return this.usuarios.current_page;
        },
        pagesNumberUsuario() {
            if (!this.usuarios.to) {
                return [];
            }
            var from = this.usuarios.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.usuarios.last_page) {
                to = this.usuarios.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods:{
        cambiarVista(vista){
            this.vista = vista
            switch(this.vista)
            {
                case 'Usuarios':this.usuariosHabilitados();break;
            }
        },
        listarUsuarios() {
            axios.get('usuario-'+this.show_usuarios+'?pagina='+this.pagina_usuario+'&buscar='+this.buscar_usuario)
            .then((respuesta) => {
                this.usuarios=respuesta.data
                this.total = this.usuarios.total
            })
        },
        getResultsUsuarios(page=1){
            axios.get('usuario-'+this.show_usuarios+'?page='+page+'&pagina='+this.pagina_usuario+'&buscar='+this.buscar_usuario)
            .then(response => {
                this.usuarios = response.data
                this.total = this.usuarios.total
            });
        },
        usuariosTodos()
        {
            this.show_usuarios = 'todos'
            this.listarUsuarios()
            this.getResultsUsuarios()
        },
        usuariosHabilitados()
        {
            this.show_usuarios = 'habilitados'
            this.listarUsuarios()
            this.getResultsUsuarios()
        },
        usuariosEliminados()
        {
            this.show_usuarios = 'eliminados'
            this.listarUsuarios()
            this.getResultsUsuarios()
        },
        changePageUsuarios(page) {
            this.usuarios.current_page = page;
            this.getResultsUsuarios(page)
        },
        buscarUsuario()
        {
            this.listarUsuarios()
            this.getResultsUsuarios()
        },
        limpiarUsuario()
        {
            this.errores=[]
            this.usuario.id=''
            this.usuario.nombre=''
            this.usuario.usuario=''
            this.usuario.email=''
            this.usuario.password=''
            this.usuario.estado=1
            this.usuario.role_id=''
        },
        obtenerRoles()
        {
            axios.get('role-lista')
            .then((respuesta)=>{
                this.rolesLista = respuesta.data
            })
        },
        nuevoUsuario()
        {
            this.limpiarUsuario()
            this.obtenerRoles()
            this.usuario.estadoCrud='nuevo'
            $('#modal-usuario-title').html('Nuevo Usuario')        
            $('#modal-usuario').modal('show')
        },
        guardarUsuario()
        {
            axios.post('user',this.usuario)
            .then((respuesta) =>{
                if(respuesta.data.ok==1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-usuario').modal('hide')
                    this.errores=[]
                    this.usuariosHabilitados()
                }   
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        mostrarDatos(usuario)
        {
            axios.get('usuario-mostrar?id='+usuario)
            .then(respuesta=>{                
                let user = respuesta.data
                this.usuario.id = user.id
                this.usuario.nombre = user.nombre
                this.usuario.usuario = user.usuario
                this.usuario.email = user.email
                this.usuario.role_id = user.role_id
                this.usuario.estado = user.estado               
            })
        },
        mostrarUsuario(usuario)
        {
            this.limpiarUsuario()
            this.mostrarDatos(usuario)
            this.usuario.estadoCrud = 'mostrar'
            this.obtenerRoles()
            $('#modal-mostrar-usuario').modal('show')
        },
        editarUsuario(usuario)
        {
            this.limpiarUsuario()
            this.obtenerRoles()
            this.mostrarDatos(usuario)
            this.usuario.estadoCrud = 'editar'
            $('#modal-usuario-title').html('Editar Usuario')        
            $('#modal-usuario').modal('show')
        },
        eliminarUsuario(id) {
            Swal.fire({
                title:"USUARIO",
                text:'¿Está Seguro de Eliminar el Usuario?',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    this.eliminarUsuarioTemporal(id)
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarUsuarioPermanente(id)
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarUsuarioTemporal(id){
            axios.post('usuario-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Usuario',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.usuariosHabilitados()
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
        eliminarUsuarioPermanente(id) {
            axios.post('usuario-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'USUARIOS',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        this.usuariosHabilitados()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    swal.fire({
                        icon : 'error',
                        title : 'USUARIOS',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurarUsuario(id) {
            swal.fire({
                title:"Usuario",
                text:'¿Está Seguro de Restaurar el Usuario?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('usuario-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Usuarios',
                                text : response.data.mensaje,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            }).then(respuesta => {
                                if(respuesta.value) {
                                    this.usuariosHabilitados()
                                }
                            })

                        }
                    })
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                            swal.fire({
                                icon : 'error',
                                title : 'Usuarios',
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
                        title : 'Usuario',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
    }
})