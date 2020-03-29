@extends('layouts.app')

@section('title', 'Vehículo Proveedor - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proveedor - Repuestos para </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.proveedor.vehiculo.store', ['proveedor' => $proveedor->id]) }}" method="POST">
            @csrf
            <h4>Agregar Marcas</h4>

            <div class="form-group">
              <label class="control-label" for="proveedor">Proveedor: *</label>
              <input  class="form-control" type="text" value="{{ $proveedor->email }}" readonly>
            </div>

            <div class="form-group">
              <label class="control-label" for="marcas">Marcas: *</label>
              <select id="marcas" class="form-control" name="marcas[]" multiple="multiple" required>
                <option>Selecciona...</option>
                @foreach($marcas as $marca)
                  <option value="{{ $marca->id }}" {{ old('marca') == $marca->id ? 'selected' : '' }}>{{ $marca->marca }}</option>
                @endforeach
              </select>
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
              <a class="btn btn-default" href="{{ route('admin.proveedor.show', ['proveedor' => $proveedor->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#marcas').select2({
        placeholder: 'Seleccione...',
      });
    })
  </script>
@endsection
