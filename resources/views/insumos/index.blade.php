@extends('layouts.app')

@section('title', 'Insumos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('insumos.index') }}"> Insumos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Insumos ({{ $insumos->count() }})</h4>
          @if(Auth::user()->role != 'user')
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('insumos.create') }}">
              <i class="fa fa-plus"></i> Agregar Insumo
            </a>
          @endif
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
                <th scope="col" class="text-center">Tipo</th>
              </tr>
            </thead>
            <tbody>
              @foreach($insumos as $insumo)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                  <td>
                    <a href="{{ route('insumos.show', ['insumo' => $insumo->id] )}}">
                      {{ $insumo->nombre }}
                    </a>
                  </td>
                  <td class="text-center">
                    <div class="img-container">
                      <img class="img-fluid img-thumbnail" src="{{ $insumo->getPhoto($insumo->foto) }}" alt="{{ $insumo->nombre }}" style="max-height: 75px">
                    </div>
                  </td>
                  <td class="text-right">{{ $insumo->getStock(true) }}</td>
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
@endsection
