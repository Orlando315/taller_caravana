@extends('layouts.app')

@section('title', 'Stock - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('insumos.show', ['insumo' => $stock->insumo->id]) }}"> Stock </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')
    
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('stocks.update', ['stock' => $stock->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              <h4>Editar Stock</h4>

              <div class="form-group">
                <label class="control-label" for="stock">Stock: *</label>
                <input id="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" step="1" min="0" max="99999999" value="{{ old('stock', $stock->stock) }}" placeholder="Stock" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="minimo">Stock mínimo:</label>
                <input id="minimo" class="form-control{{ $errors->has('minimo') ? ' is-invalid' : '' }}" type="number" name="minimo" step="1" min="0" max="99999999" value="{{ old('minimo', $stock->minimo) }}" placeholder="Stock mínimo">
                <small class="form-text text-muted">Usado para las alertas.</small>
              </div>

              @if(count($errors) > 0)
              <div class="alert alert-danger alert-important">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <div class="form-group text-right">
                <a class="btn btn-default" href="{{ route('insumos.show', ['insumo' => $stock->insumo->id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
