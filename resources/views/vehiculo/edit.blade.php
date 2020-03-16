@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('vehiculo.update', ['vehiculo' => $vehiculo->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <h4>Editar Vehículo</h4>

            <div class="form-group">
              <label class="control-label" for="año">Año: *</label>
              <select id="año" class="form-control" name="año" required>
                <option value="">Seleccione...</option>
                @foreach($anios as $anio)
                  <option value="{{ $anio->id }}" {{ old('anio') == $anio->id ? 'selected' : ($anio->id == $vehiculo->vehiculo_anio_id ? 'selected' : '') }}>{{ $anio->anio() }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label class="control-label" for="modelo">Modelos: *</label>
              <select id="modelo" class="form-control" name="modelo" required>
                <option value="">Seleccione...</option>
                @foreach($marcas as $marca)
                  <optgroup label="{{ $marca->marca }}">
                    @foreach($marca->modelos as $modelo)
                      <option value="{{ $modelo->id }}" {{ old('modelo') == $modelo->id ? 'selected' : ($vehiculo->vehiculo_modelo_id == $modelo->id ? 'selected' : '') }}>{{ $modelo->modelo }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label class="control-label" for="vin">Vin:</label>
              <input id="vin" class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }}" type="text" name="vin" maxlength="50" value="{{ old('vin', $vehiculo->vin) }}" placeholder="Vin">
            </div>

            <div class="form-group">
              <label class="control-label" for="color">Color:</label>
              <input id="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" type="text" name="color" maxlength="50" value="{{ old('color', $vehiculo->color) }}" placeholder="Color">
            </div>

            <div class="form-group">
              <label class="control-label" for="patentes">Patentes: *</label>
              <input id="patentes" class="form-control{{ $errors->has('patentes') ? ' is-invalid' : '' }}" type="text" name="patentes" maxlength="50" value="{{ old('patentes', $vehiculo->patentes) }}" placeholder="Patentes" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="km">Km:</label>
              <input id="km" class="form-control{{ $errors->has('km') ? ' is-invalid' : '' }}" type="number" name="km" min="0" max="9999999" step="0.01" value="{{ old('km', $vehiculo->km) }}" placeholder="Km">
              <small class="help-block text-muted">Solo números.</small>
            </div>

            <div class="form-group">
              <label class="control-label" for="motor">Motor <span class="text-lowercase">(cc)</span>:</label>
              <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" name="motor" min="0" max="9999" step="1" value="{{ old('motor', $vehiculo->motor) }}" placeholder="Motor">
              <small class="text-muted">Solo números.</small>
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
              <a class="btn btn-default" href="{{ route('vehiculo.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
      $('#cliente, #marca, #modelo, #año').select2({
        placeholder: 'Seleccione...',
      });
    })
  </script>
@endsection
