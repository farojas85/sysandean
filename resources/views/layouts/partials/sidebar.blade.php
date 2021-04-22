<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">SysAndean</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Buscar..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- <li class="nav-header">NAVEGACI&Oacute;N</li> --}}
                <li class="nav-item">
                    <a href="home" class="nav-link {{ Request::is('home') ? 'active' :''}}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                           Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="sistema" class="nav-link {{ Request::is('sistema') ? 'active' :''}}">
                        <i class="nav-icon fas fa-cogs text-warning"></i>
                        <p>
                           Sistema
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="materia-prima" class="nav-link {{ Request::is('materia-prima') ? 'active' :''}}">
                        <i class="nav-icon fas fa-box text-green"></i>
                        <p>
                           Materia Prima
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lote" class="nav-link {{ Request::is('lote') ? 'active' :''}}">
                        <i class="nav-icon fas fa-clone text-pink"></i>
                        <p>
                           Lote
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pelado-quimico" class="nav-link {{ Request::is('pelado-quimico') ? 'active' :''}}">
                        <i class="nav-icon fas fa-carrot text-orange"></i>
                        <p>
                           Pelado Qu&iacute;mico
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="rectificado" class="nav-link {{ Request::is('rectificado') ? 'active' :''}}">
                        <i class="nav-icon fas fa-swimming-pool text-white"></i>
                        <p>
                           Rectificado
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="plaqueado" class="nav-link {{ Request::is('plaqueado') ? 'active' :''}}">
                        <i class="nav-icon fab fa-buffer text-danger"></i>
                        <p>
                           Plaqueado
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="congelado" class="nav-link  {{ Request::is('congelado') ? 'active' :''}}">
                        <i class="nav-icon fas fa-icicles text-cyan"></i>
                        <p>
                           Congelado
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="home" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                           Envasado
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="home" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                           Cajas
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
