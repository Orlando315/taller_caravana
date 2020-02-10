@extends('layouts.app')

@section('title', 'Tipos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.tipos.index') }}"> Tipos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.tipos.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->isAdmin())
        <a class="btn btn-success" href="{{ route('admin.tipos.edit', ['tipo' => $tipo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
        <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
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
          <strong>Tipo</strong>
          <p class="text-muted">
            {{ $tipo->tipo }}
          </p>
          <hr>

          <strong>Insumos</strong>
          <p class="text-muted">
            {{ $insumos->count() }}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $tipo->created_at->format('d-m-Y H:i:s') }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Insumos ({{ $insumos->count() }})</h4>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Foto</th>
                <th scope="col" class="text-center">Stock</th>
                <th scope="col" class="text-center">Grado</th>
              </tr>
            </thead>
            <tbody>
              @foreach($insumos as $insumo)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.insumos.show', ['insumo' => $insumo->id] )}}">
                      {{ $insumo->nombre }}
                    </a>
                  </td>
                  <td class="text-center">
                    <div class="img-container">
                      <img class="img-fluid img-thumbnail" src="{{ $insumo->getPhoto() }}" alt="{{ $insumo->nombre }}" style="max-height: 75px">
                    </div>
                  </td>
                  <td class="text-right">{{ $insumo->getStock(true) }}</td>
                  <td>{{ $insumo->grado }}</td>
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
            <h4 class="modal-title" id="delModalLabel">Eliminar Tipo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-8" action="{{ route('admin.tipos.destroy', ['tipo' => $tipo->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Tipo?</p><br>

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
