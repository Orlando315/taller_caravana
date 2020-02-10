@extends('layouts.app')

@section('title', 'Iniciar Proceso - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proceso de cotización </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.proceso.store') }}" method="POST">
            @csrf
            <h4>Iniciar proceso de cotización</h4>

            <div class="form-group">
              <label class="control-label" for="cliente">Cliente: *</label>
              <select id="cliente" class="form-control" name="cliente" required>
                <option value="">Seleccione...</option>
                @foreach($clientes as $cliente)
                  <option value="{{ $cliente->id }}" {{ old('cliente') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre() }}</option>
                @endforeach
              </select>
              <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#clienteModal">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Cliente
              </button>
            </div>

            <div class="form-group">
              <label class="control-label" for="vehiculo">Vehículo: *</label>
              <select id="vehiculo" class="form-control" name="vehiculo"  required disabled>
              </select>
              <button class="btn btn-simple btn-link btn-sm btn-vehiculo" type="button" data-toggle="modal" data-target="#vehiculoModal" disabled>
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar vehículo
              </button>
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
              <a class="btn btn-default" href="{{ route('admin.proceso.index') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="clienteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel">
    <div class="modal-dialog dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="clienteModalLabel">Agregar cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="cliente-form" class="col-md-10" action="{{ Route('admin.cliente.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <label class="control-label" for="nombres">Nombres: *</label>
                <input id="nombres" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" type="text" name="nombres" maxlength="50" value="{{ old('nombres') }}" placeholder="Nombres" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="apellidos">Apellidos:</label>
                <input id="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') }}" placeholder="Apellidos">
              </div>

              <div class="form-group">
                <label class="control-label" for="rut">RUT: *</label>
                <input id="rut" class="form-control" type="text" name="rut" maxlength="11" pattern="^(\d{4,9}-[\dk])$" value="{{ old('rut') }}" placeholder="RUT" required>
                <small class="text-muted">Ejemplo: 00000000-0</small>
              </div>

              <div class="form-group">
                <label class="control-label" for="telefono">Teléfono: *</label>
                <input id="telefono" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" type="text" name="telefono" maxlength="15" value="{{ old('telefono') }}" placeholder="Teléfono" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="email">Email: *</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" maxlength="50" value="{{ old('email') }}" placeholder="Email" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="direccion">Dirección:</label>
                <input id="direccion" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" type="text" name="direccion" maxlength="150" value="{{ old('direccion') }}" placeholder="Dirección">
              </div>

              <div class="form-group">
                <label class="control-label" for="contraseña">Contraseña: *</label>
                <input id="contraseña" class="form-control{{ $errors->has('contraseña') ? ' is-invalid' : '' }}" type="password" name="contraseña" maxlength="30" placeholder="Contraseña" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="contraseña_confirmation">Confirmar contraseña: *</label>
                <input id="contraseña_confirmation" class="form-control{{ $errors->has('contraseña_confirmation') ? ' is-invalid' : '' }}" type="password" name="contraseña_confirmation" maxlength="30" placeholder="Confirmar contraseña" required>
              </div>

              <div class="alert alert-dismissible alert-danger alert-option" role="alert" style="display: none">
                <strong class="text-center">Ha ocurrido un error</strong> 

                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="alert alert-danger alert-important" style="display: none">
                <ul id="cliente-form-errors" class="m-0">
                </ul>
              </div>

              <center>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="cliente-submit" class="btn btn-fill btn-primary" type="submit">Guardar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="vehiculoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vehiculoModalLabel">
    <div class="modal-dialog dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="vehiculoModalLabel">Agregar Vehículo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="vehiculo-form" class="col-md-10" action="{{ route('admin.vehiculo.store') }}" method="POST">
              <input id="cliente-vehiculo" type="hidden" name="cliente">
              @csrf

              <div class="form-group">
                <label class="control-label" for="año">Año: *</label>
                <select id="año" class="form-control" name="año" required style="width: 100%">
                  <option value="">Seleccione...</option>
                  @foreach($anios as $anio)
                    <option value="{{ $anio->id }}" {{ old('anio') == $anio->id ? 'selected' : '' }}>{{ $anio->anio() }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="modelo">Modelos: *</label>
                <select id="modelo" class="form-control" name="modelo" required style="width: 100%">
                  <option value="">Seleccione...</option>
                  @foreach($marcas as $marca)
                    <optgroup label="{{ $marca->marca }}">
                      @foreach($marca->modelos as $modelo)
                        <option value="{{ $modelo->id }}" {{ old('modelo') == $modelo->id ? 'selected' : '' }}>{{ $modelo->modelo }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="vin">Vin: *</label>
                <input id="vin" class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }}" type="text" name="vin" maxlength="50" value="{{ old('vin') }}" placeholder="Vin" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="color">Color:</label>
                <input id="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" type="text" name="color" maxlength="50" value="{{ old('color') }}" placeholder="Color">
              </div>

              <div class="form-group">
                <label class="control-label" for="patentes">Patentes: *</label>
                <input id="patentes" class="form-control{{ $errors->has('patentes') ? ' is-invalid' : '' }}" type="text" name="patentes" maxlength="50" value="{{ old('patentes') }}" placeholder="Patentes" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="km">Km:</label>
                <input id="km" class="form-control{{ $errors->has('km') ? ' is-invalid' : '' }}" type="number" name="km" min="0" max="9999999" step="0.01" value="{{ old('km') }}" placeholder="Km">
                <small class="help-block text-muted">Solo números.</small>
              </div>


              <div class="alert alert-dismissible alert-danger alert-option" role="alert" style="display: none">
                <strong class="text-center">Ha ocurrido un error</strong> 

                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="alert alert-danger alert-important" style="display: none">
                <ul id="vehiculo-form-errors" class="m-0">
                </ul>
              </div>

              <center>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="vehiculo-submit" class="btn btn-fill btn-primary" type="submit">Guardar</button>
              </center>
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
      $('#cliente, #vehiculo, #año, #modelo').select2({
        placeholder: 'Seleccione...',
      });

      // Buscar vehiculos
      $('#cliente').on('change',function () {
        let cliente = $(this).val()
        
        if(!cliente){
          $('#cliente-vehiculo').val('')
          $('.btn-vehiculo').prop('disabled', true)
          return false
        }

        $('#vehiculo').prop('disabled', true)
        $('#cliente-vehiculo').val(cliente)
        $('.btn-vehiculo').prop('disabled', false)

        $.ajax({
          type: 'POST',
          url: `{{ route("admin.cliente.index") }}/${cliente}/vehiculos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (vehiculos) {
          $('#vehiculo').html('<option value="">Seleccione...</option>');
          $.each(vehiculos, function(k, vehiculo){
            let selected = (@json(old('vehiculo')) == vehiculo.id) ? 'selected' : ''
            $('#vehiculo').append(`<option value="${vehiculo.id}" ${selected}>${vehiculo.marca.marca} - ${vehiculo.modelo.modelo } (${vehiculo.anio.anio })</option>`)
          })

          $('#vehiculo').prop('disabled', false)
        })
        .fail(function () {
          $('#vehiculo').prop('disabled', true)
        })
      })

      $('#cliente').change()

      // Agregar cliente
      $('#cliente-form').submit(function(e){
        e.preventDefault()

        $('#cliente-submit').prop('disabled', true)
        $('#cliente-form-errors').empty()

        let form = $(this),
            action = form.attr('action');

        $.ajax({
          type: 'POST',
          data: form.serialize(),
          url: action,
          dataType: 'json'
        })
        .done(function (data) {
          if(data.response == true){
            $(`#cliente`).append(`<option value="${data.cliente.id}">${data.cliente.nombre}</option`)
            $(`#cliente`).val(data.cliente.id)
            $(`#cliente`).trigger('change')
            $('#cliente-form')[0].reset()
            $('#clienteModal').modal('hide')
            $('#año, #modelo').change()
          }else{
            alertOption.show().delay(7000).hide('slow');
          }
        })
        .fail(function (response) {
          alertOption.show().delay(7000).hide('slow');
          showErrors(response.responseJSON.errors, '#cliente-form-errors')
        })
        .always(function () {
          $('#cliente-submit').prop('disabled', false)
        })
      })

      // Agregar vehiculo
      $('#vehiculo-form').submit(function(e){
        e.preventDefault()

        $('#vehiculo-submit').prop('disabled', true)
        $('#vehiculo-form-errors').empty()

        let form = $(this),
            action = form.attr('action');

        $.ajax({
          type: 'POST',
          data: form.serialize(),
          url: action,
          dataType: 'json'
        })
        .done(function (data) {
          if(data.response == true){
            $('#cliente').change()
            $('#vehiculo-form')[0].reset()
            $('#vehiculoModal').modal('hide')
          }else{
            alertOption.show().delay(7000).hide('slow');
          }
        })
        .fail(function (response) {
          alertOption.show().delay(7000).hide('slow');
          showErrors(response.responseJSON.errors, '#vehiculo-form-errors')
        })
        .always(function () {
          $('#vehiculo-submit').prop('disabled', false)
        })
      })

    })

    const alertOption = $('.alert-option');

    function showErrors(errors, ul){
      $.each(errors, function (k, v){
        if($.isArray(v)){
          $.each(v, function (k2, error){
            $(ul).append(`<li>${error}</li>`);
          })
        }else{
          $(ul).append(`<li>${v}</li>`);
        }
      })

      $(ul).parent().show().delay(7000).hide('slow');
    }
  </script>
@endsection
