@extends('layouts.app')

@section('title', 'Proveedor - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proveedor </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.proveedor.store') }}" method="POST">
            @csrf
            <h4>Agregar Proveedor</h4>

            <div class="form-group">
              <label class="control-label" for="email">Email:</label>
              <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email"  value="{{ old('email') }}" placeholder="Email">
            </div>

            <div class="form-group">
              <label class="control-label" for="proveedor">Proveedor: *</label>
              <input id="proveedor" class="form-control{{ $errors->has('proveedor') ? ' is-invalid' : '' }}" type="text" name="proveedor"  value="{{ old('proveedor') }}" placeholder="Proveedor" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="vendedor">Vendedor: *</label>
              <input id="vendedor" class="form-control{{ $errors->has('vendedor') ? ' is-invalid' : '' }}" type="text" name="vendedor" maxlength="50" value="{{ old('vendedor') }}" placeholder="Vendedor" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="direccion">Dirección: *</label>
              <textarea class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" placeholder="Dirección" required>{{ old('direccion') }}</textarea>
            </div>
            
            <div class="form-group">
              <label class="control-label" for="telefono_local">Teléfono Local:</label>
              <input id="telefono_local" class="form-control{{ $errors->has('telefono_local') ? ' is-invalid' : '' }}" type="text" name="telefono_local" maxlength="15" value="{{ old('telefono_local') }}" placeholder="Teléfono Local">
            </div>

            <div class="form-group">
              <label class="control-label" for="telefono_celular">Teléfono Celular:</label>
              <input id="telefono_celular" class="form-control{{ $errors->has('telefono_celular') ? ' is-invalid' : '' }}" type="text" name="telefono_celular" maxlength="15" value="{{ old('telefono_celular') }}" placeholder="Teléfono Celular">
            </div>

            <div class="form-group">
              <label class="control-label" for="descuento_convenio">Descuento:</label>
              <input id="descuento_convenio" class="form-control{{ $errors->has('descuento_convenio') ? ' is-invalid' : '' }}" type="number" name="descuento_convenio" min="0" max="99999999" step="0.01" value="{{ old('descuento_convenio') }}" placeholder="Descuento">
            </div>

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.proveedor.index') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
