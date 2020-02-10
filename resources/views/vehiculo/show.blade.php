@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('vehiculo.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <a class="btn btn-success" href="{{ route('vehiculo.edit', ['vehiculo' => $vehiculo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
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
          <strong>Marca</strong>
          <p class="text-muted">
            {{ $vehiculo->marca->marca }}
          </p>
          <hr>

          <strong>Modelo</strong>
          <p class="text-muted">
            {{ $vehiculo->modelo->modelo }}
          </p>
          <hr>

          <strong>Vin</strong>
          <p class="text-muted">
            {{ $vehiculo->vin ?? 'N/A' }}
          </p>
          <hr>

          <strong>Año</strong>
          <p class="text-muted">
            {{ $vehiculo->anio->anio() }}
          </p>
          <hr>

          <strong>Color</strong>
          <p class="text-muted">
            {{ $vehiculo->color ?? 'N/A' }}
          </p>
          <hr>

          <strong>Km</strong>
          <p class="text-muted">
            {{ $vehiculo->km() ?? 'N/A' }}
          </p>
          <hr>

          <strong>Patentes</strong>
          <p class="text-muted">
            {{ $vehiculo->patentes ?? 'N/A' }}
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
                    <a href="{{ route('proceso.show', ['proceso' => $proceso->id] )}}" title="Ver proceso">
                      {{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'N/A' }}
                    </a>
                  </td>
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
            <form class="col-md-8" action="{{ route('vehiculo.destroy', ['vehiculo' => $vehiculo->id]) }}" method="POST">
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
@endsection
