@extends('layouts.app')

@section('title', 'Modelos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Modelos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.vehiculo.modelo.store') }}" method="POST">
            @csrf

            <h4>Agregar Modelo</h4>

            <div class="form-group">
              <label class="control-label" for="marca">Marca: *</label>
              <select id="marca" class="form-control" name="marca" required>
                <option value="">Seleccione...</option>
                @foreach($marcas as $marca)
                  <option value="{{ $marca->id }}" {{ old('marca') == $marca->id ? 'selected' : '' }}>{{ $marca->marca }}</option>
                @endforeach
              </select>
              <small><a class="text-muted" href="{{ route('admin.vehiculo.marca.create') }}">Agregar marca</a></small>
            </div>

            <div class="form-group">
              <label class="control-label" for="modelo">Modelo: *</label>
              <input id="modelo" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" type="text" name="modelo" maxlength="50" value="{{ old('modelo') }}" placeholder="Modelo" required>
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
              <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
      $('#marca').select2({
        placeholder: 'Seleccione...',
      });
    })
  </script>
@endsection
