@extends('layouts.app')

@section('title', 'Inicio - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Inicio </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row">
    @if(Auth::user()->isStaff())
      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.cliente.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-address-book"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Clientes</p>
                    <h4 class="card-title">{{ $clientes }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.insumos.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-th-large"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Stock bajo</p>
                    <h4 class="card-title">{{ $insumosWithStockMinimo->count() }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.proceso.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-tasks"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Servicios</p>
                    <h4 class="card-title">{{ $procesosCount }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    @else
      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('vehiculo.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-car"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Vehículos</p>
                    <h4 class="card-title">{{ $vehiculos }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('proceso.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-tasks"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Servicios</p>
                    <h4 class="card-title">{{ $procesosCount }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endif
  </div>

  @if(Auth::user()->isStaff())
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-clock-o text-info" aria-hidden="true"></i> Reporte de finanzas</h4>
            </div>
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <li class="list-group-item" rel="tooltip" title="Total de ventas">Total ventas: {{ number_format($finanzas['ventas'], 2,',', '.') }} </li>
                <li class="list-group-item" rel="tooltip" title="Pagos pendientes por cotizaciones abiertas">Pagos pendientes: {{ number_format($finanzas['pendiente'], 2,',', '.') }} </li>
                <li class="list-group-item" rel="tooltip" title="Utilidades por cotizaciones cerrdas">Total utilidades: {{ number_format($finanzas['utilidades'], 2,',', '.') }} </li>
              </ul>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="fa fa-calendar-o" aria-hidden="true"></i> Mes en curso: {{ ucfirst(strftime("%B")) }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-dollar text-success" aria-hidden="true"></i> Efectividad del servicio</h4>
            </div>
            <div class="card-body">
              <h5 class="text-center">{{ $efectividad }}</h5>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="fa fa-tasks" aria-hidden="true"></i> En base a {{ $procesosCompletados }} servicios completados
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2"></div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><i class="fa fa-calendar text-danger" aria-hidden="true"></i> Agendamientos</h4>
        </div>
        <div class="card-body">
          <div id="calendar" class="border-top border-secondary pt-2 calendar-small"></div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Servicios Activos ({{ $procesosActivos->count() }})</h4>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Cliente</th>
                <th scope="col" class="text-center">Vehículo</th>
                <th scope="col" class="text-center">Agendamiento</th>
                <th scope="col" class="text-center">Pre-evaluación</th>
                <th scope="col" class="text-center">Cotización</th>
                <th scope="col" class="text-center">Estatus</th>
              </tr>
            </thead>
            <tbody>
              @foreach($procesosActivos as $proceso)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ Auth::user()->isStaff() ? route('admin.proceso.show', ['proceso' => $proceso->id]) : route('proceso.show', ['proceso' => $proceso->id]) }}" title="Ver proceso">
                      {{ $proceso->cliente->nombre() }}
                    </a>
                  </td>
                  <td>{{ $proceso->vehiculo->vehiculo() }}</td>
                  <td class="text-center">{{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'N/A' }}</td>
                  <td class="text-center">{!! $proceso->preevaluacionesStatus() !!}</td>
                  <td class="text-center">{!! $proceso->cotizacionesStatus() !!}</td>
                  <td class="text-center">{!! $proceso->status() !!}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript">
    let agendamientos = @json($agendamientosCalendar);

    $(document).ready(function(){
      $('#calendar').fullCalendar({
        defaultView: 'agendaWeek',
        themeSystem: 'bootstrap4',
        timezone: 'local',
        allDaySlot: false,
        minTime: '07:00:00',
        maxTime: '19:00:00',
        slotLabelFormat: 'h:mm a',
        slotLabelInterval: {
          minutes: 30,
        },
        slotDuration:{
          minutes: 30,
        },
        forceEventDuration: true,
        defaultTimedEventDuration:{
          minutes: 30,
        },
        events : agendamientos,
      });
    })
  </script>
@endsection
