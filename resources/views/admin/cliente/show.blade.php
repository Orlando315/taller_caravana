@extends('layouts.app')

@section('title', 'Clientes - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cliente.index') }}"> Clientes </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.cliente.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <a class="btn btn-success" href="{{ route('admin.cliente.edit', ['cliente' => $cliente->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
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
          <strong>Nombres</strong>
          <p class="text-muted">
            {{ $cliente->nombres }}
          </p>
          <hr>

          <strong>Apellidos</strong>
          <p class="text-muted">
            {{ $cliente->apellidos }}
          </p>
          <hr>

          <strong>Teléfono</strong>
          <p class="text-muted">
            {{ $cliente->telefono }}
          </p>
          <hr>

          <strong>Email</strong>
          <p class="text-muted">
            {{ $cliente->email }}
          </p>
          <hr>

          <strong>Dirección</strong>
          <p class="text-muted">
            {{ $cliente->direccion }}
          </p>
          <hr>

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
      
    </div>
  </div>

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
@endsection
