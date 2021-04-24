<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li v-if="this.$auth.user">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true" >
              <img src="{{ asset('images/user.png') }}" height="32">@auth {{ Auth::user()->nombre}} @else Invitado @endauth
          </a>
          <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-divider"></div>
              <a href="" class="dropdown-item">
                  <i class="fas fa-user mr-2"></i> Mi Perfil
              </a>
              <div class="dropdown-divider"></div>
              <a href="" class="dropdown-item">
                  <i class="fas fa-cogs mr-2"></i> Configuraciones
              </a>
              <div class="dropdown-divider"></div>
              <a  href="{{ route('logout') }}" class="dropdown-item"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off mr-2"></i> Cerrar Sesi&oacute;n
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
          </a>
      </li>
  </ul>
</nav>
