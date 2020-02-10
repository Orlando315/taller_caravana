@extends('layouts.app')

@section('title', 'Stock - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.insumos.show', ['insumo' => $stock->insumo_id]) }}"> Stock </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')
    
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.insumos.stock.update', ['stock' => $stock->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              <h4>Editar Stock</h4>

              <div class="form-group">
                <label class="control-label" for="coste">Coste: *</label>
                <input id="coste" class="form-control{{ $errors->has('coste') ? ' is-invalid' : '' }}" type="number" name="coste" step="0.01" min="0" max="99999999" value="{{ old('coste', $stock->coste) }}" placeholder="Coste" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="venta">Venta: *</label>
                <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" name="venta" step="0.01" min="0" max="99999999" value="{{ old('venta', $stock->venta) }}" placeholder="Venta" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="stock">Stock: *</label>
                <input id="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" step="1" min="0" max="99999999" value="{{ old('stock', $stock->stock) }}" placeholder="Stock" required>
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
                <a class="btn btn-default" href="{{ route('admin.insumos.show', ['insumo' => $stock->insumo_id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
