@extends('layouts.app')

@section('title', 'Stock - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.insumos.show', ['insumo' => $stock->insumo_id]) }}"> Stock </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')
    
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.insumos.stock.update', ['stock' => $stock->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')

              <h4>Editar Stock</h4>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="coste">Coste: *</label>
                    <input id="coste" class="form-control{{ $errors->has('coste') ? ' is-invalid' : '' }}" type="number" name="coste" step="0.01" min="0" max="99999999" value="{{ old('coste', $stock->coste) }}" placeholder="Coste" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" name="venta" step="0.01" min="0" max="99999999" value="{{ old('venta', $stock->venta) }}" placeholder="Venta" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="stock">Stock: *</label>
                    <input id="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" step="1" min="0" max="99999999" value="{{ old('stock', $stock->stock) }}" placeholder="Stock" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="factura"># factura:</label>
                    <input id="factura" class="form-control{{ $errors->has('factura') ? ' is-invalid' : '' }}" type="text" name="factura" maxlength="50" value="{{ old('factura', $stock->factura) }}" placeholder="# Factura">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="foto_factura">Foto de la factura:</label>
                    <div class="custom-file">
                      <input id="foto_factura" class="custom-file-input{{ $errors->has('foto_factura') ? ' is-invalid' : '' }}" type="file" name="foto_factura" lang="es" data-browse="Elegir" accept="image/jpeg,image/png">
                      <label class="custom-file-label" for="foto_factura">Seleccionar</label>
                    </div>
                  </div>
                </div>
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

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id')

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });
    })
  </script>
@endsection
