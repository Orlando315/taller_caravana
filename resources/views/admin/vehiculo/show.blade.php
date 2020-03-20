@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->isAdmin())
      <a class="btn btn-success" href="{{ route('admin.vehiculo.edit', ['vehiculo' => $vehiculo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
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
          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $vehiculo->cliente_id]) }}">
              {{ $vehiculo->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Marca</strong>
          <p class="text-muted">
            <a href="{{ route('admin.vehiculo.marca.show', ['marca' => $vehiculo->vehiculo_marca_id]) }}">
              {{ $vehiculo->marca->marca }}
            </a>
          </p>
          <hr>

          <strong>Modelo</strong>
          <p class="text-muted">
            <a href="{{ route('admin.vehiculo.modelo.show', ['modelo' => $vehiculo->vehiculo_modelo_id]) }}">
              {{ $vehiculo->modelo->modelo }}
            </a>
          </p>
          <hr>

          <strong>Año</strong>
          <p class="text-muted">
            <a href="{{ route('admin.vehiculo.anio.show', ['anio' => $vehiculo->vehiculo_anio_id]) }}">
              {{ $vehiculo->anio->anio() }}
            </a>
          </p>
          <hr>

          <strong>Motor</strong>
          <p class="text-muted" title="{{ $vehiculo->motor }} cc">
            {{ $vehiculo->motor ? $vehiculo->motor() : 'N/A' }}
          </p>
          <hr>

          <strong>VIN</strong>
          <p class="text-muted">
            {{ $vehiculo->vin ?? 'N/A' }}
          </p>
          <hr>

          <strong>Color</strong>
          <p class="text-muted">
            {{ $vehiculo->color ?? 'N/A' }}
          </p>
          <hr>

          <strong>Patentes</strong>
          <p class="text-muted">
            {{ $vehiculo->patentes ?? 'N/A' }}
          </p>
          <hr>

          <strong>Km</strong>
          <p class="text-muted">
            {{ $vehiculo->km() ?? 'N/A' }}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $vehiculo->createdAt() }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Procesos ({{ $procesos->count() }})</h4>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Cliente</th>
                <th scope="col" class="text-center">Agendamiento</th>
                <th scope="col" class="text-center">Pre-evaluación</th>
                <th scope="col" class="text-center">Cotización</th>
                <th scope="col" class="text-center">Estatus</th>
              </tr>
            </thead>
            <tbody>
              @foreach($procesos as $proceso)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.proceso.show', ['proceso' => $proceso->id] )}}" title="Ver proceso">
                      {{ $proceso->cliente->nombre() }}
                    </a>
                  </td>
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
  
  @if(Auth::user()->isAdmin())
  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Vehículo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.vehiculo.destroy', ['vehiculo' => $vehiculo->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Vehículo?</p><br>

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
