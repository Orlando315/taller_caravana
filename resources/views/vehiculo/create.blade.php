@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('vehiculo.store') }}" method="POST">
            @csrf

            <h4>Agregar Vehículo</h4>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="marca">Marca: *</label>
                  <select id="marca" class="form-control" name="marca" required>
                    <option value="">Seleccione...</option>
                    @foreach($marcas as $marca)
                      <option value="{{ $marca->id }}" {{ old('marca') == $marca->id ? 'selected' : '' }}>{{ $marca->marca }}</option>
                    @endforeach
                  </select>
                </div>                
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="modelo">Modelo: *</label>
                  <select id="modelo" class="form-control" name="modelo" required disabled>
                    <option value="">Seleccione...</option>
                    @foreach($marca->modelos as $modelo)
                      <option value="{{ $modelo->id }}" {{ old('modelo') == $modelo->id ? 'selected' : '' }}>{{ $modelo->modelo }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="año">Año: *</label>
                  <select id="año" class="form-control" name="año" required>
                    <option value="">Seleccione...</option>
                    @foreach($anios as $anio)
                      <option value="{{ $anio->id }}" {{ old('anio') == $anio->id ? 'selected' : '' }}>{{ $anio->anio() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="motor">Motor (cc):</label>
                  <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" name="motor" min="0" max="9999" step="1" value="{{ old('motor') }}" placeholder="Motor">
                  <small class="text-muted">Solo números.</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="vin">VIN: *</label>
                  <input id="vin" class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }}" type="text" name="vin" maxlength="50" value="{{ old('vin') }}" placeholder="Vin" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="color">Color:</label>
                  <input id="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" type="text" name="color" maxlength="50" value="{{ old('color') }}" placeholder="Color">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="patente">Patente: *</label>
                  <input id="patente" class="form-control{{ $errors->has('patente') ? ' is-invalid' : '' }}" type="text" name="patente" maxlength="50" value="{{ old('patente') }}" placeholder="Patente" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="km">Km:</label>
                  <input id="km" class="form-control{{ $errors->has('km') ? ' is-invalid' : '' }}" type="number" name="km" min="0" max="9999999" step="0.01" value="{{ old('km') }}" placeholder="Km">
                  <small class="help-block text-muted">Solo números.</small>
                </div>
              </div>
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
      $('#marca, #modelo, #año').select2({
        placeholder: 'Seleccione...',
      });

      $('#marca').on('change',function () {
        let marca = $(this).val()

        if(!marca){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("vehiculo.marca.modelos") }}/${marca}/modelos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (modelos) {
          $('#modelo').html('<option value="">Seleccione...</option>');
          $.each(modelos, function(k, modelo){
            let selected = modelo.id == @json(old('modelo')) ? 'selected' : ''
            $('#modelo').append(`<option value="${modelo.id}" ${selected}>${modelo.modelo}</option>`)
          })

          $('#modelo').prop('disabled', false)
        })
        .fail(function () {
          $('#modelo').prop('disabled', true)
        })
      })

      $('#marca').change()
    })
  </script>
@endsection
