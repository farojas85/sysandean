var app= new Vue({
    el: '#wrapper',
    data: {
        vista:'Usuarios',
        offset:4,
        errores:[],
        pagina_usuario:5,
        buscar_usuario:'',
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
                case 'Usuarios':
                    this.listarUsuarios()
                    this.getResultsUsuarios();break
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
        changePageUsuarios(page) {
            this.usuarios.current_page = page;
            this.getResultsUsuarios(page)
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
            this.usuario.estadoCrud='nuevo'
        },
        nuevoUsuario()
        {
            this.limpiarUsuario()        
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