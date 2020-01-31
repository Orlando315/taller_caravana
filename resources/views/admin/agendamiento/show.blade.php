@extends('layouts.app')

@section('title', 'Agendamientos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.agendamiento.index') }}"> Agendamientos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.agendamiento.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <a class="btn btn-success" href="{{ route('admin.agendamiento.edit', ['agendamiento' => $agendamiento->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row mt-2">
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
            <a href="{{ route('admin.cliente.show', ['cliente' => $agendamiento->vehiculo->cliente_id]) }}">
              {{ $agendamiento->vehiculo->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $agendamiento->vehiculo->marca->marca.' - '.$agendamiento->vehiculo->modelo->modelo.'('.$agendamiento->vehiculo->anio->anio.')' }}
          </p>
          <hr>

          <strong>Fecha</strong>
          <p class="text-muted">
            {{ $agendamiento->fecha->format('d-m-Y H:i:s') }} {{ $agendamiento->inmediatamente ? 'Atendido inmediatamente' : '' }}
          </p>
        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $agendamiento->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>
  </div>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Agendamiento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-10" action="{{ route('admin.agendamiento.destroy', ['agendamiento' => $agendamiento->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Agendamiento?</p><br>

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
