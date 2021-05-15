var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Usuarios',
        offset:4,
        errores:[],
        pagina_usuario:5,
        buscar_usuario:'',
        rolesLista:[],
        tipoDocumentosLista:[],
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
        },
        pagina_trabajador:5,
        buscar_trabajador:'',
        trabajadores:{},
        total_trabajadores:0,
        show_trabajadores:'habilitados',
        trabajador:{
            id:'',
            tipo_documento_id:'',
            numero_documento:'',
            nombres:'',
            apellidos:'',
            fecha_nacimiento:'',
            lugar_nacimiento:'',
            estado:'',
            estadoCrud:'nuevo'
        },
        pagina_permiso:5,
        buscar_permiso:'',
        permisos:[],
        total_permisos:0,
        show_permisos:'habilitados',
        permiso:{
            id:'',
            name:'',
            estadoCrud:'nuevo'
        },
        modelos:[],
        permiso_role:{
            role_id:'',
            role_name:'',
            modelo:'',
            permission_name:[]
        },
        permisos_select:[]
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
        isActivedTrabajador() {
            return this.trabajadores.current_page;
        },
        pagesNumberTrabajador() {
            if (!this.trabajadores.to) {
                return [];
            }
            var from = this.trabajadores.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.trabajadores.last_page) {
                to = this.trabajadores.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
        isActivedPermiso() {
            return this.permisos.current_page;
        },
        pagesNumberPermiso() {
            if (!this.permisos.to) {
                return [];
            }
            var from = this.permisos.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.permisos.last_page) {
                to = this.permisos.last_page;
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
                case 'Trabajadores':this.trabajadoresHabilitados();break;
                case 'Permisos':this.listarPermissions();break;
                case 'Permisos/Roles':this.listarPermisoRole();break;
            }
        },
        cambiarPaginacionUsuario(event)
        {
            this.pagina_usuario = event.target.value
            this.listarUsuarios()
            this.getResultsUsuarios()
        },
        listarUsuarios() {
            axios.get('usuario-'+this.show_usuarios+'?pagina='+this.pagina_usuario+'&buscar='+this.buscar_usuario)
            .then((respuesta) => {
                this.usuarios=respuesta.data
                this.total_usuarios = this.usuarios.total
            })
        },
        getResultsUsuarios(page=1){
            axios.get('usuario-'+this.show_usuarios+'?page='+page+'&pagina='+this.pagina_usuario+'&buscar='+this.buscar_usuario)
            .then(response => {
                this.usuarios = response.data
                this.total_usuarios = this.usuarios.total
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
        obtenerTipoDocumentos()
        {
            axios.get('tipo-documento-lista')
            .then((respuesta)=>{
                this.tipoDocumentosLista = respuesta.data
            })
        },
        cambiarPaginacionTrabajador(event)
        {
            this.pagina_trabajador = event.target.value
            this.listarTrabajadores()
            this.getResultsTrabajadores()
        },
        listarTrabajadores() {
            axios.get('trabajador-'+this.show_trabajadores+'?pagina='+this.pagina_trabajador+'&buscar='+this.buscar_trabajador)
            .then((respuesta) => {
                this.trabajadores=respuesta.data
                this.total_trabajadores = this.trabajadores.total
            })
        },
        getResultsTrabajadores(page=1){
            axios.get('trabajador-'+this.show_trabajadores+'?page='+page+'&pagina='+this.pagina_trabajador+'&buscar='+this.buscar_trabajador)
            .then(response => {
                this.trabajadores = response.data
                this.total_trabajadores = this.trabajadores.total
            });
        },
        trabajadoresTodos()
        {
            this.show_trabajadores = 'todos'
            this.listarTrabajadores()
            this.getResultstrabajadores()
        },
        trabajadoresHabilitados()
        {
            this.show_trabajadores = 'habilitados'
            this.listarTrabajadores()
            this.getResultsTrabajadores()
        },
        trabajadoresEliminados()
        {
            this.show_trabajadores = 'eliminados'
            this.listarTrabajadores()
            this.getResultsTrabajadores()
        },
        changePageTrabajadores(page) {
            this.trabajadores.current_page = page;
            this.getResultsTrabajadores(page)
        },
        limpiarTrabajador()
        {
            this.errores=[]
            this.trabajador.id=''
            this.trabajador.tipo_documento_id=''
            this.trabajador.numero_documento=''
            this.trabajador.nombres=''
            this.trabajador.apellidos=''
            this.trabajador.fecha_nacimiento=''
            this.trabajador.lugar_nacimiento=''
            this.trabajador.estado=1
        },
        nuevoTrabajador()
        {
            this.limpiarTrabajador()
            this.obtenerTipoDocumentos()
            this.trabajador.estadoCrud='nuevo'
            $('#modal-trabajador-title').html('Nuevo Trabajador')        
            $('#modal-trabajador').modal('show')
        },
        validarDocumento()
        {
            axios.get('trabajador-validar-documento',{params: this.trabajador})
            .then((respuesta) =>{
                this.errores=[]
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    console.clear()
                }
            })
        },
        guardarTrabajador()
        {
            axios.post('trabajador',this.trabajador)
            .then((respuesta) =>{
                if(respuesta.data.ok==1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-trabajador').modal('hide')
                    this.errores=[]
                    this.trabajadoresHabilitados()
                }   
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    //console.clear()
                }
            })
        },
        mostrarDatosTrabajador(trabajador)
        {
            axios.get('trabajador-mostrar?id='+trabajador)
            .then(respuesta=>{                
                let trab = respuesta.data
                this.trabajador.id = trab.id
                this.trabajador.tipo_documento_id = trab.tipo_documento_id
                this.trabajador.numero_documento = trab.numero_documento
                this.trabajador.nombres = trab.nombres
                this.trabajador.apellidos = trab.apellidos
                this.trabajador.fecha_nacimiento = trab.fecha_nacimiento
                this.trabajador.lugar_nacimiento = trab.lugar_nacimiento
                this.trabajador.estado = trab.estado               
            })
        },
        mostrarTrabajador(trabajador)
        {
            this.limpiarTrabajador()
            this.mostrarDatosTrabajador(trabajador)
            this.trabajador.estadoCrud = 'mostrar'
            this.obtenerTipoDocumentos()
            $('#modal-mostrar-trabajador').modal('show')
        },
        editarTrabajador(trabajador)
        {
            this.limpiarTrabajador()
            this.obtenerTipoDocumentos()
            this.mostrarDatosTrabajador(trabajador)
            this.trabajador.estadoCrud = 'editar'
            $('#modal-trabajador-title').html('Editar Trabajador')        
            $('#modal-trabajador').modal('show')
        },
        eliminarTrabajador(id) {
            Swal.fire({
                title:"Trabajador",
                text:'¿Está Seguro de Eliminar el Usuario?',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    this.eliminarTrabajadorTemporal(id)
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarTrabajadorPermanente(id)
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarTrabajadorTemporal(id){
            axios.post('trabajador-eliminar-temporal',{id:id})
            .then((response) => {
                if(response.data.ok==1)
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Trabajador',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.trabajadoresHabilitados()
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
        eliminarTrabajadorPermanente(id) {
            axios.post('trabajador-eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Trabajadores',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        this.trabajadoresHabilitados()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    swal.fire({
                        icon : 'error',
                        title : 'Trabajadores',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        restaurarTrabajador(id) {
            swal.fire({
                title:"Trabajador",
                text:'¿Está Seguro de Restaurar el Usuario?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('trabajador-restaurar',{id:id})
                    .then((response) => {
                        if(response.data.ok==1)
                        {
                            swal.fire({
                                icon : 'success',
                                title : 'Trabajadores',
                                text : response.data.mensaje,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            }).then(respuesta => {
                                if(respuesta.value) {
                                    this.trabajadoresHabilitados()
                                }
                            })

                        }
                    })
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                            swal.fire({
                                icon : 'error',
                                title : 'Trabajadores',
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
                        title : 'Trabajadores',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        cambiarPaginacionPermiso(event)
        {
            this.pagina_permiso = event.target.value
            this.listarPermisos()
            this.getResultPermisos()
        },
        listarPermissions()
        {
            this.listarPermisos()
            this.getResultPermisos()
        },
        listarPermisos() {
            axios.get('permiso?pagina='+this.pagina_permiso+'&buscar='+this.buscar_permiso)
            .then((respuesta) => {
                this.permisos=respuesta.data
                this.total_permisos = this.permisos.total
            })
        },
        getResultPermisos(page=1){
            axios.get('permiso?page='+page+'&pagina='+this.pagina_permiso+'&buscar='+this.buscar_permiso)
            .then(response => {
                this.permisos = response.data
                this.total_permisos = this.permisos.total
            });
        },
        changePagePermisos(page) {
            this.permisos.current_page = page;
            this.getResultPermisos(page)
        },
        buscarPermiso()
        {
            this.listarPermisos()
            this.getResultPermisos()
        },
        limpiarPermiso() {
            this.errores=[]
            this.permiso.id=''
            this.permiso.name = ''
        },
        nuevoPermiso(){
            this.limpiarPermiso()
            this.permiso.estadoCrud='nuevo'
            $('#modal-permiso-title').html('Nuevo Permiso')        
            $('#modal-permiso').modal('show')
        },
        guardarPermiso() {
            axios.post('permiso',this.permiso)
            .then((respuesta) =>{
                if(respuesta.data.ok==1)
                {
                    Toast.fire({icon:'success','title' : respuesta.data.mensaje})
                    $('#modal-permiso').modal('hide')
                    this.errores=[]
                    this.listarPermissions()
                }   
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    //console.clear()
                }
            })
        },
        mostrarDatosPermiso(permiso)
        {
            this.limpiarPermiso()
            axios.get('permiso-mostrar?id='+permiso)
            .then((respuesta) =>{
                let permi = respuesta.data
                this.permiso.id = permi.id
                this.permiso.name = permi.name
                             
            })
        },
        mostrarPermiso(permiso)
        {
            this.mostrarDatosPermiso(permiso)
            this.permiso.estadoCrud = 'mostrar'  
            $('#modal-permiso-title').html('Mostrar Permiso')        
            $('#modal-permiso').modal('show')
        },
        editarPermiso(permiso)
        {
            this.mostrarDatosPermiso(permiso)
            this.permiso.estadoCrud = 'editar'  
            $('#modal-permiso-title').html('Editar Permiso')        
            $('#modal-permiso').modal('show')
        },
        eliminarPermiso(permiso)
        {
            Swal.fire({
                title:"Trabajador",
                text:'¿Está Seguro de Eliminar el Permiso?',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-check'></i> Si",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-times'></i> No",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    axios.post('permiso-eliminar',{id:permiso})
                    .then((response) => (
                        swal.fire({
                            icon : 'success',
                            title : 'Permisos',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listarPermissions()
                            }
                        })
                    ))
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                            swal.fire({
                                icon : 'error',
                                title : 'Trabajadores',
                                text : this.errores,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            })
                        }
                    })
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        listarModelos()
        {
            axios.get('permiso-role-modelos')
            .then(respuesta => {
                this.modelos = respuesta.data
            })
        },
        listarPermisoRole()
        {
            this.obtenerRoles()
            this.listarModelos()
        },
        mostrarRolePermisos(e)
        {
            this.permiso_role.modelo=e.target.value
            axios.get('permiso-role-permisos',{params: this.permiso_role})
                .then((response) => {
                    let permi = response.data.permissions
                    let role = response.data.role
                    this.permisos_select = permi
                    this.permiso_role.permission_name=[]
                    this.permiso_role.role_name = role[0].name 
                    if(role.length >0 )
                    {
                        if(role[0].permissions.length>0)
                        {
                                role[0].permissions.forEach(item => {
                                    this.permiso_role.permission_name.push(item.name)
                                })
                        }
                    }
                    this.errores = []
                })
                .catch((errors) => {
                    if(response = errors.response){
                        this.errores = response.data.errors;
        
                    }
                })
        },
        limpiarPermissionRole()
        {
            this.permiso_role.role_id=''
            this.permiso_role.role_name=''
            this.permiso_role.modelo=''
            this.permiso_role.permission_name=[]
            this.permisos_select = []
        },
        guardarRolePermiso()
        {
            axios.post('permiso-role-guardar',this.permiso_role)
                .then((response) => {
                    if(response.data.ok == 1)
                    {
                        swal.fire({
                            icon : 'success',
                            title : 'PERMISOS / ROLES',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.limpiarPermissionRole()
                            }
                        })
                    }
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        }
    }
})