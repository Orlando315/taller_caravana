@extends('layouts.app')

@section('title', 'Clientes - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cliente.index') }}"> Clientes </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.cliente.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

      @if(Auth::user()->isAdmin())
      <a class="btn btn-success" href="{{ route('admin.cliente.edit', ['cliente' => $cliente->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-3">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Nombres</strong>
          <p class="text-muted">
            {{ $cliente->user->nombres }}
          </p>
          <hr>

          <strong>Apellidos</strong>
          <p class="text-muted">
            {{ $cliente->user->apellidos ?? 'N/A' }}
          </p>
          <hr>

          <strong>Teléfono</strong>
          <p class="text-muted">
            {{ $cliente->telefono }}
          </p>
          <hr>

          <strong>Email</strong>
          <p class="text-muted">
            {{ $cliente->user->email }}
          </p>
          <hr>

          <strong>Dirección</strong>
          <p class="text-muted">
            {{ $cliente->direccion }}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $cliente->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="false"><i class="fa fa-tasks" aria-hidden="true"></i> Procesos ({{ $procesos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="true"><i class="fa fa-car" aria-hidden="true"></i> Vehículos ({{ $vehiculos->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Vehículo</th>
                    <th scope="col" class="text-center">Agendamiento</th>
                    <th scope="col" class="text-center">Pre-evaluación</th>
                    <th scope="col" class="text-center">Cotización</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($procesos as $proceso)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                      <td>
                        <a href="{{ route('admin.proceso.show', ['proceso' => $proceso->id] )}}" title="Ver proceso">
                          {{ $proceso->vehiculo->vehiculo() }}
                        </a>
                      </td>
                      <td class="text-center">{{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'N/A' }}</td>
                      <td class="text-center">{!! $proceso->preevaluacionesStatus() !!}</td>
                      <td class="text-center">{!! $proceso->cotizacionesStatus() !!}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->

            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab">
              @if(Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.vehiculo.create', ['cliente' => $cliente->id]) }}">
                <i class="fa fa-plus"></i> Agregar vehículo
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Marca</th>
                    <th scope="col" class="text-center">Modelo</th>
                    <th scope="col" class="text-center">Año</th>
                    <th scope="col" class="text-center">Color</th>
                    <th scope="col" class="text-center">Patente</th>
                    <th scope="col" class="text-center">Agregado</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($vehiculos as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.vehiculo.show', ['vehiculo' => $d->id]) }}">
                          {{ $d->marca->marca }}
                        </a>
                      </td>
                      <td>{{ $d->modelo->modelo }}</td>
                      <td>{{ $d->anio->anio() }}</td>
                      <td>{{ $d->color }}</td>
                      <td>{{ $d->patentes }}</td>
                      <td>{{ $d->createdAt() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div>
  </div>
  
  @if(Auth::user()->isAdmin())
  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.cliente.destroy', ['user' => $cliente->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Cliente?</p><br>

              <center>
                <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
@endsection
