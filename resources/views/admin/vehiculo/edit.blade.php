@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.vehiculo.update', ['vehiculo' => $vehiculo->id]) }}" method="POST">
              @csrf
              @method('PUT')

              <h4>Editar Vehículo</h4>

              <div class="form-group">
                <label class="control-label" for="cliente">Cliente: *</label>
                <select id="cliente" class="form-control" name="cliente" required>
                  <option value="">Seleccione...</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente') == $cliente->id ? 'selected' : ($cliente->id == $vehiculo->cliente_id ? 'selected' : '') }}>{{ $cliente->nombre() }}</option>
                  @endforeach
                </select>
                <small><a class="text-muted" href="{{ route('admin.cliente.create') }}">Agregar cliente</a></small>
              </div>

              <div class="form-group">
                <label class="control-label" for="año">Año: *</label>
                <select id="año" class="form-control" name="año" required>
                  <option value="">Seleccione...</option>
                  @foreach($anios as $anio)
                    <option value="{{ $anio->id }}" {{ old('anio') == $anio->id ? 'selected' : ($anio->id == $vehiculo->vehiculo_anio_id ? 'selected' : '') }}>{{ $anio->anio }}</option>
                  @endforeach
                </select>
                <small><a class="text-muted" href="{{ route('admin.vehiculo.anio.create') }}">Agregar año</a></small>
              </div>

              <div class="form-group">
                <label class="control-label" for="marca">Marca: *</label>
                <select id="marca" class="form-control" name="marca" required>
                  <option value="">Seleccione...</option>
                  @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}" {{ old('marca') == $marca->id ? 'selected' : ($marca->id == $vehiculo->vehiculo_marca_id ? 'selected' : '') }}>{{ $marca->marca }}</option>
                  @endforeach
                </select>
                <small><a class="text-muted" href="{{ route('admin.vehiculo.marca.create') }}">Agregar marca</a></small>
              </div>

              <div class="form-group">
                <label class="control-label" for="modelo">Modelo: *</label>
                <select id="modelo" class="form-control" name="modelo" disabled required>
                  <option value="">Seleccione...</option>
                </select>
                <small><a class="text-muted" href="{{ route('admin.vehiculo.marca.create') }}">Agregar modelo</a></small>
              </div>

              <div class="form-group">
                <label class="control-label" for="color">Color:</label>
                <input id="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" type="text" name="color" maxlength="50" value="{{ old('color', $vehiculo->color) }}" placeholder="Color">
              </div>

              <div class="form-group">
                <label class="control-label" for="patentes">Patentes:</label>
                <input id="patentes" class="form-control{{ $errors->has('patentes') ? ' is-invalid' : '' }}" type="text" name="patentes" maxlength="50" value="{{ old('patentes', $vehiculo->patentes) }}" placeholder="Patentes">
              </div>

              <div class="form-group">
                <label class="control-label" for="km">Km:</label>
                <input id="km" class="form-control{{ $errors->has('km') ? ' is-invalid' : '' }}" type="number" name="km" min="0" max="9999999" step="0.01" value="{{ old('km', $vehiculo->km) }}" placeholder="Km">
                <small class="help-block text-muted">Solo números.</small>
              </div>

              <div class="form-group">
                <label class="control-label" for="vin">Vin:</label>
                <input id="vin" class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }}" type="text" name="vin" maxlength="50" value="{{ old('vin', $vehiculo->vin) }}" placeholder="Vin">
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
                <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
    $(document).ready(function(){
      $('#cliente, #marca, #modelo, #año').select2({
        placeholder: 'Seleccione...',
      });

      $('#marca').on('change',function () {
        let marca = $(this).val()

        if(!marca){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("admin.vehiculo.marca.index") }}/${marca}/modelos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (modelos) {
          $('#modelo').html('<option value="">Seleccione...</option>');
          $.each(modelos, function(k, modelo){
            let selected = modelo.id == @json($vehiculo->vehiculo_modelo_id) ? 'selected' : ''
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