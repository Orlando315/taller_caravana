@extends('layouts.app')

@section('title', 'Insumos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('insumos.index') }}"> Insumos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
        <a class="btn btn-default" href="{{ route('insumos.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

      @if(Auth::user()->role != 'user')
        <a class="btn btn-success" href="{{ route('insumos.edit', ['insumo' => $insumo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
        <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
    </div>
  </div>

  @if($insumo->stock->stock <= $insumo->stock->minimo)
    <div class="row justify-content-md-center mt-2">
      <div class="col-md-6">
        <div class="alert alert-dismissible alert-important alert-danger m-0" role="alert">
          <strong class="text-center">El Stock actual esta por debajo del mínimo establecido.</strong>
        </div>
      </div>
    </div>
  @endif
  
  @include('partials.flash')

  <div class="row mt-2">
    <div class="col-12">
      <div class="card card-information">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 text-center">
              <figure class="figure w-100 m-0">
                <img src="{{ $insumo->getPhoto($insumo->foto) }}" class="figure-img img-thumbnail img-fluid m-0" alt="{{ $insumo->nombre }}" style="max-height: 150px;">
              </figure>
            </div>
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-7">
                  <h4 class="m-0">{{ $insumo->nombre }}</h4>
                  <small class="text-muted">
                    {{ $insumo->marca }} |
                    <a href="{{ route('tipos.show', ['tipo' => $insumo->tipo_id]) }}">{{ $insumo->tipo->tipo }}</a> |
                    {{ $insumo->grado }} |
                    <a href="{{ route('formatos.show', ['formato' => $insumo->formato_id]) }}">{{ $insumo->formato->formato }}</a>
                  </small>
                  <p class="m-0">{{ $insumo->descripcion }}</p>
                </div>
                <div class="col-md-5">
                  <h4 class="m-0">
                    Factura
                    <button class="btn btn-link btn-info btn-xs" data-toggle="modal" data-target="#facturaModal"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </h4>
                  <p class="m-0"># {{ $insumo->factura }}</p>
                  <p class="m-0">Coste: {{ $insumo->costo() }}</p>
                  <p class="m-0">Venta: {{ $insumo->venta() }}</p>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <h4 class="m-0 border-top">
                    Stock
                  </h4>
                  <small><a class="text-muted" href="{{ route('stocks.edit', ['stock' => $insumo->stock->id]) }}">Editar</a></small>
                  <p class="m-0">
                    Stock: {{ $insumo->stock->stock }} |
                    Stock mínimo: {{ $insumo->stock->minnimo ?? 'N/A' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="facturaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="facturaModalLabel">
    <div class="modal-dialog dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="facturaModalLabel">Factura</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <div class="col-md-10 text-center">
              <figure class="figure w-100 m-0">
                <img src="{{ $insumo->getPhoto($insumo->foto_factura) }}" class="figure-img img-thumbnail img-fluid m-0" alt="{{ $insumo->nombre }}" style="max-height: 70vh;">
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(Auth::user()->role != 'user')
    <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delModalLabel">Eliminar Insumo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-8" action="{{ route('insumos.destroy', ['insumo' => $insumo->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Insumo?</p><br>

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
