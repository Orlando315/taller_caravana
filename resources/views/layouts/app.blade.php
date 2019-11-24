<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', config('app.name'))</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/light-bootstrap-dashboard.css?v=2.0.0') }}" rel="stylesheet"/>
    <!-- Datatabes -->
    <link href="{{ asset('js/plugins/datatables/datatables.min.css') }}" rel="stylesheet"/>
    <!-- App -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    @yield('head', '')

  </head>
  <body>
    <div class="wrapper">
      <div class="sidebar" data-color="red" data-image="{{ asset('images/bike.jpg') }}">
        <div class="sidebar-wrapper">
          <div class="logo">
            <a href="{{ route('dashboard') }}" class="simple-text">
              {{ config('app.name') }}
            </a>
          </div>
          <ul class="nav">
            <li class="nav-item{{ $currentRoute == 'dashboard' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
                <p>Inicio</p>
              </a>
            </li>

            @if(Auth::user()->isAdmin())
            <li class="nav-item{{ $currentRoute == 'admin' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fa fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#menu-insumos" aria-expanded="true">
                <i class="fa fa-th-large"></i>
                <p>Insumos <b class="caret"></b></p>
              </a>
              <div id="menu-insumos" class="collapse{{ in_array($currentRoute, ['insumos', 'tipos', 'formatos']) ? ' show' : '' }}">
                <ul class="nav">
                  <li class="nav-item{{ $currentRoute == 'insumos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('insumos.index') }}">
                      <span class="sidebar-mini">I</span>
                      <span class="sidebar-normal">Insumos</span>
                    </a>
                  </li>
                  <li class="nav-item{{ $currentRoute == 'tipos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('tipos.index') }}">
                      <span class="sidebar-mini">T</span>
                      <span class="sidebar-normal">Tipos</span>
                    </a>
                  </li>
                  <li class="nav-item{{ $currentRoute == 'formatos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('formatos.index') }}">
                      <span class="sidebar-mini">F</span>
                      <span class="sidebar-normal">Formatos</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>

          </ul>
        </div>
      </div>
      <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg " color-on-scroll="500">
          <div class="container-fluid">

            @yield('brand', '')

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-bar burger-lines"></span>
              <span class="navbar-toggler-bar burger-lines"></span>
              <span class="navbar-toggler-bar burger-lines"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <ul class="nav navbar-nav mr-auto">
              </ul>
              <ul class="navbar-nav ml-auto">
                @if(Auth::user()->isAdmin())
                  <li class="nav-item">
                    <a href="{{ route('admin.users.create') }}" class="nav-link" rel="tooltip" title="Agregar usuario">
                      <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar usuario
                    </a>
                  </li>
                @endif

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->email }}
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('perfil') }}">
                        <i class="fa fa-user"></i> Mi perfil
                      </a>
                      <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="dropdown-item text-danger" type="submit">
                          <i class="fa fa-sign-out" aria-hidden="true" style="line-height: 1"></i> Salir
                        </button>
                      </form>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        
        <!-- End Navbar -->
        <div class="content">
          <div class="container-fluid">

            @yield('content')

          </div>
        </div>
        <footer class="footer">
          <div class="container-fluid">
            <nav>
              <p class="copyright text-center">
              </p>
            </nav>
          </div>
        </footer>
      </div><!-- Main-panel -->
    </div>
    <!-- Core JS Files -->
    <script src="{{ asset('js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="{{ asset('js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Data-table -->
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('.alert').not('.alert-important').delay(7000).slideUp(300);

        $('.data-table').DataTable({
          responsive: true,
          language: {
            url: '{{ asset("js/plugins/datatables/spanish.json") }}'
          },
          pageLength: 25
        });
      })
    </script>

    @yield('scripts')

  </body>
</html>
