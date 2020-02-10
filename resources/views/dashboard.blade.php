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
        <a href="{{ route('admin.vehiculo.index') }}">
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
                    <p class="card-category">Insumos</p>
                    <h4 class="card-title">{{ $insumos }}</h4>
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
                    <p class="card-category">Procesos</p>
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
                    <p class="card-category">Procesos</p>
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

  <div class="row">
    <div class="col-12">
      <h4 class="text-center"> Procesos activos </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Procesos ({{ $procesosActivos->count() }})</h4>
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
