@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.vehiculo.update', ['vehiculo' => $vehiculo->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <h4>Editar Vehículo</h4>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="cliente">Cliente: *</label>
                  <select id="cliente" class="form-control" name="cliente" required>
                    <option value="">Seleccione...</option>
                    @foreach($clientes as $cliente)
                      <option value="{{ $cliente->id }}" {{ old('cliente') == $cliente->id ? 'selected' : ($cliente->id == $vehiculo->cliente_id ? 'selected' : '') }}>{{ $cliente->nombre() }}</option>
                    @endforeach
                  </select>
                  <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#clienteModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar Cliente
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="marca">Marca: *</label>
                  <select id="marca" class="form-control" name="marca" required>
                    <option value="">Seleccione...</option>
                    @foreach($marcas as $marca)
                      <option value="{{ $marca->id }}" {{ old('marca') == $marca->id ? 'selected' : ($marca->id == $vehiculo->vehiculo_marca_id ? 'selected' : '') }}>{{ $marca->marca }}</option>
                    @endforeach
                  </select>
                  <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#optionModal" data-option="marca">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar marca
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="modelo">Modelo: *</label>
                  <select id="modelo" class="form-control" name="modelo" disabled required>
                    <option value="">Seleccione...</option>
                  </select>
                  <button class="btn btn-simple btn-link btn-sm btn-modelo" type="button" data-toggle="modal" data-target="#optionModal" data-option="modelo" disabled>
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar modelo
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="año">Año: *</label>
                  <select id="año" class="form-control" name="año" required>
                    <option value="">Seleccione...</option>
                    @foreach($anios as $anio)
                      <option value="{{ $anio->id }}" {{ old('anio') == $anio->id ? 'selected' : ($anio->id == $vehiculo->vehiculo_anio_id ? 'selected' : '') }}>{{ $anio->anio() }}</option>
                    @endforeach
                  </select>
                  <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#optionModal" data-option="año">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar año
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="motor">Motor <span class="text-lowercase">(cc)</span>:</label>
                  <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" name="motor" min="0" max="9999" step="1" value="{{ old('motor', $vehiculo->motor) }}" placeholder="Motor">
                  <small class="text-muted">Solo números.</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="vin">VIN:</label>
                  <input id="vin" class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }}" type="text" name="vin" maxlength="50" value="{{ old('vin', $vehiculo->vin) }}" placeholder="Vin">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="color">Color:</label>
                  <input id="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" type="text" name="color" maxlength="50" value="{{ old('color', $vehiculo->color) }}" placeholder="Color">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="patente">Patente: *</label>
                  <input id="patente" class="form-control{{ $errors->has('patente') ? ' is-invalid' : '' }}" type="text" name="patente" maxlength="50" value="{{ old('patente', $vehiculo->patentes) }}" placeholder="Patente" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="km">Km:</label>
                  <input id="km" class="form-control{{ $errors->has('km') ? ' is-invalid' : '' }}" type="number" name="km" min="0" max="9999999" step="0.01" value="{{ old('km', $vehiculo->km) }}" placeholder="Km">
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
              <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
                <input id="nombres" class="form-control" type="text" name="nombres" maxlength="50" placeholder="Nombres" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="apellidos">Apellidos:</label>
                <input id="apellidos" class="form-contro" type="text" name="apellidos" maxlength="50" placeholder="Apellidos">
              </div>

              <div class="form-group">
                <label class="control-label" for="rut">RUT: *</label>
                <input id="rut" class="form-control" type="text" name="rut" maxlength="11" pattern="^(\d{4,9}-[\dk])$" placeholder="RUT" required>
                <small class="text-muted">Ejemplo: 00000000-0</small>
              </div>

              <div class="form-group">
                <label class="control-label" for="telefono">Teléfono: *</label>
                <input id="telefono" class="form-control" type="text" name="telefono" maxlength="15" placeholder="Teléfono" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="email">Email: *</label>
                <input id="email" class="form-control" type="email" name="email" maxlength="50" placeholder="Email" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="direccion">Dirección:</label>
                <input id="direccion" class="form-control" type="text" name="direccion" maxlength="150" placeholder="Dirección">
              </div>

              <div class="form-group">
                <label class="control-label" for="contraseña">Contraseña: *</label>
                <input id="contraseña" class="form-control" type="password" name="contraseña" maxlength="30" placeholder="Contraseña" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="contraseña_confirmation">Confirmar contraseña: *</label>
                <input id="contraseña_confirmation" class="form-control" type="password" name="contraseña_confirmation" maxlength="30" placeholder="Confirmar contraseña" required>
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

  <div id="optionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="optionModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="optionModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="option-form" class="col-md-8" action="#" method="POST">
              @csrf

              <fieldset id="set-año" style="display: none" disabled>
                <div class="form-group">
                  <label class="control-label" for="option-anio">Año: </label>
                  <input id="option-anio" class="form-control" type="text" name="año" maxlength="20" required>
                </div>
              </fieldset>

              <fieldset id="set-marca" style="display: none" disabled>
                <div class="form-group">
                  <label class="control-label" for="option-marca">Marca: *</label>
                  <input id="option-marca" class="form-control" type="text" name="marca" maxlength="50" placeholder="Marca" required>
                </div>
              </fieldset>

              <fieldset id="set-modelo" style="display: none" disabled>
                <input id="option-marca-modelo" type="hidden" name="marca" value="">
                <div class="form-group">
                  <label class="control-label" for="option-modelo">Modelo: *</label>
                  <input id="option-modelo" class="form-control" type="text" name="modelo" maxlength="50" required>
                </div>
              </fieldset>

              <div class="alert alert-dismissible alert-danger alert-option" role="alert" style="display: none">
                <strong class="text-center">Ha ocurrido un error</strong> 

                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="alert alert-danger alert-important anios-form-errors" style="display: none">
                <ul id="option-form-errors" class="m-0">
                </ul>
              </div>

              <center>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="option-submit" class="btn btn-fill btn-primary" type="submit">Guardar</button>
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
      $('#cliente, #marca, #modelo, #año').select2({
        placeholder: 'Seleccione...',
      });

      $('#marca').on('change',function () {
        let marca = $(this).val()

        if(!marca){
          $('.btn-modelo').prop('disabled', true); 
          return false
        }
        $('.btn-modelo').prop('disabled', false)

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
            let selected = modelo.id == @json(old('modelo', $vehiculo->vehiculo_modelo_id)) ? 'selected' : ''
            $('#modelo').append(`<option value="${modelo.id}" ${selected}>${modelo.modelo}</option>`)
          })

          $('#modelo').prop('disabled', false)
        })
        .fail(function () {
          $('#modelo').prop('disabled', true)
        })
      })

      $('#marca').change()

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

      // Agregar año, marca, modelo
      $('#option-form').submit(function(e){
        e.preventDefault()

        $('#option-submit').prop('disabled', true)
        $('#option-form-errors').empty()

        let form = $(this),
            action = form.attr('action'),
            value = $('#option').val();

        $.ajax({
          type: 'POST',
          data: form.serialize(),
          url: action,
          dataType: 'json'
        })
        .done(function (data) {
          if(data.response == true){
            $(`#${option}`).append(`<option value="${data.option.id}">${data.option.option}</option`)
            $(`#${option}`).val(data.option.id)
            $(`#${option}`).trigger('change')
            $('#option-form')[0].reset()
            $('#optionModal').modal('hide')
          }else{
            alertOption.show().delay(7000).hide('slow');  
          }
        })
        .fail(function (response) {
          alertOption.show().delay(7000).hide('slow');
          showErrors(response.responseJSON.errors, '#option-form-errors')
        })
        .always(function () {
          $('#option-submit').prop('disabled', false)
        })
      })

      $('#optionModal').on('show.bs.modal', function(e){
        let btn = $(e.relatedTarget)
        option = btn.data('option')

        let label = option.charAt(0).toUpperCase() + option.slice(1)
        let url = option == 'año' ? '{{ route("admin.vehiculo.anio.store") }}' : (option == 'marca' ? '{{ Route("admin.vehiculo.marca.store") }}' : '{{ Route("admin.vehiculo.modelo.store") }}')

        $('#set-año, #set-marca, #set-modelo').toggle(false)
        $('#set-año, #set-marca, #set-modelo').prop('disabled', true)
        $(`#set-${option}`).show()
        $(`#set-${option}`).prop('disabled', false)

        if(option == 'modelo'){
          $('#option-marca-modelo').val($('#marca').val())
        }

        $('#option-form').attr('action', url)
        $('#option-label').text(`${label}: *`)
        $('#optionModalLabel').text(`Agregar ${label}`)
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
