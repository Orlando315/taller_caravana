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
    <!-- Select2 -->
    <link href="{{ asset('js/plugins/select2/select2.min.css') }}" rel="stylesheet"/>
    <!-- Fullcalendar -->
    <link href="{{ asset('js/plugins/fullcalendar-3.10.0/fullcalendar.min.css') }}" rel="stylesheet"/>
    <!-- App -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    @yield('head', '')

  </head>
  <body>
    <div class="wrapper">
      <div class="sidebar" data-color="green" data-image="{{ asset('images/bike.jpg') }}">
        <div class="sidebar-wrapper">
          <div class="logo py-1" style="background: white">
            <a href="{{ route('dashboard') }}" class="simple-text">
              <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" height="40">
            </a>
          </div>
          <ul class="nav">
            <li class="nav-item{{ $currentRoute == 'dashboard' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i>
                <p>Inicio</p>
              </a>
            </li>

            @if(Auth::user()->isStaff())
            <li class="nav-item{{ $currentRoute == 'admin.users' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fa fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.procesos' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.proceso.index') }}">
                <i class="fa fa-tasks"></i>
                <p>Servicios</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.pagos' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.pago.index') }}">
                <i class="fa fa-credit-card"></i>
                <p>Pagos</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.cliente' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.cliente.index') }}">
                <i class="fa fa-address-book"></i>
                <p>Clientes</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.vehiculo' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.vehiculo.index') }}">
                <i class="fa fa-car"></i>
                <p>Vehículos</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.proveedor' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.proveedor.index') }}">
                <i class="fa fa-id-card"></i>
                <p>Proveedores</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.repuesto' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.repuesto.index') }}">
                <i class="fa fa-cubes"></i>
                <p>Repuestos</p>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#menu-insumos" aria-expanded="true">
                <i class="fa fa-th-large"></i>
                <p>Insumos <b class="caret"></b></p>
              </a>
              <div id="menu-insumos" class="collapse{{ in_array($currentRoute, ['insumos', 'tipos', 'formatos']) ? ' show' : '' }}">
                <ul class="nav">
                  <li class="nav-item{{ $currentRoute == 'insumos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.insumos.index') }}">
                      <span class="sidebar-mini">I</span>
                      <span class="sidebar-normal">Insumos</span>
                    </a>
                  </li>
                  <li class="nav-item{{ $currentRoute == 'tipos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.tipos.index') }}">
                      <span class="sidebar-mini">T</span>
                      <span class="sidebar-normal">Tipos</span>
                    </a>
                  </li>
                  <li class="nav-item{{ $currentRoute == 'formatos' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.formatos.index') }}">
                      <span class="sidebar-mini">F</span>
                      <span class="sidebar-normal">Formatos</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item{{ $currentRoute == 'admin.finanzas' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.consulta.finanzas.index') }}">
                <i class="fa fa-search"></i>
                <p>Consultar finnazas</p>
              </a>
            </li>
            @else

            <li class="nav-item{{ $currentRoute == 'proceso' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('proceso.index') }}">
                <i class="fa fa-tasks"></i>
                <p>Procesos</p>
              </a>
            </li>

            <li class="nav-item{{ $currentRoute == 'vehiculo' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('vehiculo.index') }}">
                <i class="fa fa-car"></i>
                <p>Vehículos</p>
              </a>
            </li>
            @endif

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

                @if(Auth::user()->isStaff())
                  <li class="nav-item">
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.configurations.edit') : '#' }}" class="nav-link text-success" rel="tooltip">
                      <i class="fa fa-dollar" aria-hidden="true"></i> {{ Auth::user()->getDollar() }}
                    </a>
                  </li>
                  
                  @if(Auth::user()->isAdmin())
                  <li class="nav-item">
                    <a href="{{ route('admin.proceso.create') }}" class="nav-link" rel="tooltip" title="Nuevo servicio">
                      <i class="fa fa-plus" aria-hidden="true"></i> Nuevo servicio
                    </a>
                  </li>
                  @endif

                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.agendamiento.index') }}" rel="tooltip" title="Agendamientos">
                      <i class="fa fa-calendar" aria-hiddentrue></i> Agendamientos
                    </a>
                  </li>

                <li class="dropdown nav-item">
                  <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="true" rel="tooltip" title="Stock mínimo">
                    <i class="fa fa-th-large"></i>
                    @if($insumosWithStockMinimo->count() > 0)
                      <span class="notification">{{ $insumosWithStockMinimo->count() }}</span>
                    @endif
                    <span class="d-lg-none">Stock</span>
                  </a>
                  <ul class="dropdown-menu menu-notifications">
                    @forelse($insumosWithStockMinimo as $lowStock)
                      <a class="dropdown-item" href="{{ route('admin.insumos.show', ['insumo' => $lowStock->id]) }}">
                        <p class="m-0">{{ $lowStock->nombre }}</p>
                        <small class="text-muted">Stock: {{ $lowStock->getStock() }}</small>
                      </a>
                    @empty
                      <a class="dropdown-item disabled text-muted" href="#" tabindex="-1" aria-disabled="true">Stock mínimo</a>
                    @endforelse
                  </ul>
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
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}" type="text/javascript"></script>
    <!-- Data-table -->
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/plugins/select2/select2.min.js') }}" type="text/javascript"></script>
    <!-- Fullcalendar -->
    <script src="{{ asset('js/plugins/fullcalendar-3.10.0/lib/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/fullcalendar-3.10.0/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/fullcalendar-3.10.0/locale/es.js') }}" type="text/javascript"></script>

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
