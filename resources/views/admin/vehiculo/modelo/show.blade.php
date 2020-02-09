@extends('layouts.app')

@section('title', 'Modelos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Modelos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <a class="btn btn-success" href="{{ route('admin.vehiculo.modelo.edit', ['modelo' => $modelo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
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
            <a href="{{ route('admin.vehiculo.marca.show', ['marca' => $modelo->vehiculo_marca_id]) }}">
              {{ $modelo->marca->marca }}
            </a>
          </p>
          <hr>

          <strong>Modelo</strong>
          <p class="text-muted">
            {{ $modelo->modelo }}
          </p>
        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $modelo->createdAt() }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Vehículos ({{ $vehiculos->count() }})</h4>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Cliente</th>
                <th scope="col" class="text-center">Marca</th>
                <th scope="col" class="text-center">Color</th>
                <th scope="col" class="text-center">Año</th>
                <th scope="col" class="text-center">Patentes</th>
                <th scope="col" class="text-center">Agregado</th>
              </tr>
            </thead>
            <tbody>
              @foreach($vehiculos as $d)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.vehiculo.show', ['vehiculo' => $d->id]) }}">
                      {{ $d->cliente->nombre() }}
                    </a>
                  </td>
                  <td>{{ $d->marca->marca }}</td>
                  <td>{{ $d->color }}</td>
                  <td>{{ $d->anio->anio }}</td>
                  <td>{{ $d->patentes }}</td>
                  <td>{{ $d->createdAt() }}</td>
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
          <h4 class="modal-title" id="delModalLabel">Eliminar Modelo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.vehiculo.modelo.destroy', ['modelo' => $modelo->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Modelo?</p><br>

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
