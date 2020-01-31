@extends('layouts.app')

@section('title', 'Proceso - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.index') }}"> Procesos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proceso.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-4">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $proceso->cliente_id]) }}">
              {{ $proceso->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $proceso->vehiculo->vehiculo() }}
          </p>
        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $proceso->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-4">
          @if(!$proceso->agendamiento)
          <a href="{{ route('admin.agendamiento.create', ['proceso' => $proceso->id]) }}" title="Agregar agendamiento">
          @else
          <a href="{{ route('admin.agendamiento.edit', ['agendamiento' => $proceso->agendamiento->id]) }}" title="Editar agendamiento">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->agendamiento ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Agendamiento</p>
                      <p class="card-title">
                        {{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'Agregar' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-body py-1">
              <div class="row">
                <div class="col-4">
                  <div class="icon-big text-center text-muted">
                    <i class="fa fa-check-square-o"></i>
                  </div>
                </div>
                <div class="col-8">
                  <div class="numbers">
                    <p class="card-category">Pre-evaluación</p>
                    <p class="card-title">
                      -
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-body py-1">
              <div class="row">
                <div class="col-4">
                  <div class="icon-big text-center text-muted">
                    <i class="fa fa-calculator"></i>
                  </div>
                </div>
                <div class="col-8">
                  <div class="numbers">
                    <p class="card-category">Cotización</p>
                    <p class="card-title">
                      -
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Proceso</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.proceso.destroy', ['proceso' => $proceso->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Proceso?</p><br>

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

