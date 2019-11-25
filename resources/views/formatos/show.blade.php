@extends('layouts.app')

@section('title', 'Formatos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('formatos.index') }}"> Formatos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('formatos.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->role != 'user')
        <a class="btn btn-success" href="{{ route('formatos.edit', ['formato' => $formato->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      @endif
      @if(Auth::user()->isAdmin())
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
          <strong>Formato</strong>
          <p class="text-muted">
            {{ $formato->formato }}
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
            {{ $formato->created_at }}
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
                <th scope="col" class="text-center">Foto</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Stock</th>
                <th scope="col" class="text-center">Grado</th>
                <th scope="col" class="text-center">Tipo</th>
              </tr>
            </thead>
            <tbody>
              @foreach($insumos as $insumo)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                  <td class="text-center">
                    <div class="img-container">
                      <img class="img-fluid img-thumbnail" src="{{ $insumo->getPhoto($insumo->foto) }}" alt="{{ $insumo->nombre }}" style="max-height: 75px">
                    </div>
                  </td>
                  <td>
                    <a href="{{ route('insumos.show', ['insumo' => $insumo->id] )}}">
                      {{ $insumo->nombre }}
                    </a>
                  </td>
                  <td class="text-right">{{ $insumo->stock ? $insumo->stock->stock: '0' }}</td>
                  <td>{{ $insumo->grado }}</td>
                  <td>{{ $insumo->tipo->tipo }}</td>
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
            <h4 class="modal-title" id="delModalLabel">Eliminar Formato</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-8" action="{{ route('formatos.destroy', ['formato' => $formato->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Formato?</p><br>

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
