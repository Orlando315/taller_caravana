@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('head')
  <!-- fileinput -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/fileinput/fileinput.min.css')}}">
@endsection

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.repuesto.update', ['repuesto' => $repuesto->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h4>Editar Repuesto</h4>
            <fieldset>
              <legend>Datos del Repuesto</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca">Marca: *</label>
                    <select id="marca" class="form-control" name="marca" required>
                      <option value="">Seleccione...</option>
                      @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca', $repuesto->vehiculo_marca_id) == $marca->id ? 'selected' : '' }}>{{ $marca->marca }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="modelo">Modelo: *</label>
                    <select id="modelo" class="form-control" name="modelo" required disabled>
                      <option value="">Seleccione...</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="año">Año: *</label>
                    <input id="año" class="form-control{{ $errors->has('año') ? ' is-invalid' : '' }}" type="number" name="año" min="0" step="1" max="9999" value="{{ old('año', $repuesto->anio) }}" placeholder="Año" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="motor">Motor (cc): *</label>
                    <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" min="0" max="9999" name="motor" value="{{ old('motor', $repuesto->motor) }}" placeholder="Motor" required>
                    <small class="text-muted">Solo números</small>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="sistema">Sistema: *</label>
                    <input id="sistema" class="form-control{{ $errors->has('sistema') ? ' is-invalid' : '' }}" type="text" name="sistema" maxlength="50" value="{{ old('sistema', $repuesto->sistema) }}" placeholder="Sistema" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="componente">Componente: *</label>
                    <input id="componente" class="form-control{{ $errors->has('componente') ? ' is-invalid' : '' }}" type="text" name="componente" maxlength="50" value="{{ old('componente', $repuesto->componente) }}" placeholder="Componente" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_parte">N° parte:</label>
                    <input id="nro_parte" class="form-control{{ $errors->has('nro_parte') ? ' is-invalid' : '' }}" type="text" name="nro_parte" maxlength="50" value="{{ old('nro_parte', $repuesto->nro_parte) }}" placeholder="N° parte">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_oem">N° OEM:</label>
                    <input id="nro_oem" class="form-control{{ $errors->has('nro_oem') ? ' is-invalid' : '' }}" type="text" name="nro_oem" maxlength="50" value="{{ old('nro_oem', $repuesto->nro_oem) }}" placeholder="N° OEM">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca_oem">Marca OEM: *</label>
                    <input id="marca_oem" class="form-control{{ $errors->has('marca_oem') ? ' is-invalid' : '' }}" type="text" name="marca_oem" maxlength="50" value="{{ old('marca_oem', $repuesto->marca_oem) }}" placeholder="Marca OEM" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="foto">Foto:</label>
                    <div class="custom-file">
                      <input id="foto" class="custom-file-input" type="file" name="foto" lang="es" accept="image/jpeg,image/png">
                      <label class="custom-file-label" for="foto">Selecionar...</label>
                    </div>
                    <small class="text-muted">Tamaño máximo 12 MB</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="stock">Stock:</label>
                    <input id="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" min="0" max="9999" value="{{ old('stock', $repuesto->stock) }}" placeholder="Stock">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="procedencia">Procedencia: *</label>
                    <select id="procedencia" class="form-control" name="procedencia" required>
                      <option>Seleccione...</option>
                      <option value="local" {{ old('procedencia', $repuesto->procedencia) == 'local' ? 'selected' : '' }}>Local</option>
                      <option value="nacional" {{ old('procedencia', $repuesto->procedencia) == 'nacional' ? 'selected' : '' }}>Nacional</option>
                      <option value="internacional" {{ old('procedencia', $repuesto->procedencia) == 'internacional' ? 'selected' : '' }}>Internacional</option>
                    </select>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend class="title-legend">Procedencia: <span id="procedencia-title"></span></legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda">Moneda: *</label>
                    <select id="moneda" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso"{{ old('moneda', $repuesto->extra->moneda) == 'peso' ? ' selected' : '' }}>Peso chileno</option>
                      <option value="dolar"{{ old('moneda', $repuesto->extra->moneda) == 'dolar' ? ' selected' : '' }}>Dólar</option>
                      <option value="euro"{{ old('moneda', $repuesto->extra->moneda) == 'euro' ? ' selected' : '' }}>Euro</option>
                    </select>
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="moneda-valor">Especificar valor: *</label>
                    <input id="moneda-valor" class="form-control{{ $errors->has('moneda_valor') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="moneda_valor" value="{{ old('moneda_valor', $repuesto->extra->moneda_valor) }}" placeholder="Especificar valor">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" maxlength="50" value="{{ old('costo', $repuesto->extra->costo) }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="generales">Gastos generales:</label>
                    <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" maxlength="50" value="{{ old('generales', $repuesto->extra->generales) }}" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="envio">Envio:</label>
                    <input id="envio" class="form-control field-nacional{{ $errors->has('envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio" value="{{ old('envio', $repuesto->envio) }}" placeholder="Envio">
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="impuestos-internacional">Impuestos:</label>
                    <input id="impuestos-internacional" class="form-control{{ $errors->has('impuestos') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="impuestos" value="{{ old('impuestos', $repuesto->extra->impuestos) }}" placeholder="Especificar">
                  </div>
                </div>
              </div>

              <div class="row group-field-internacional" style="display:none">
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="envio1-internacional">Envio 1:</label>
                    <input id="envio1-internacional" class="form-control field-internacional{{ $errors->has('envio1') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio1" value="{{ old('envio1', $repuesto->extra->envio1) }}" placeholder="Envio 1">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="envio2-internacional">Envio 2:</label>
                    <input id="envio2-internacional" class="form-control field-internacional{{ $errors->has('envio2') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio2" value="{{ old('envio2', $repuesto->extra->envio2) }}" placeholder="Envio 2">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="casilla-internacional">Gastos casilla:</label>
                    <input id="casilla-internacional" class="form-control field-internacional{{ $errors->has('casilla') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="casilla" value="{{ old('casilla', $repuesto->extra->casilla) }}" placeholder="Gastos casilla">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" maxlength="50" value="{{ old('venta', $repuesto->venta) }}" placeholder="Venta" required>
                    <button class="btn btn-simple btn-link btn-sm btn-sugerir" type="button" role="button">
                      <i class="fa fa-calculator" aria-hidden="true"></i> Sugerir precio
                    </button>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend class="title-legend">Otros:</legend>

              <div class="form-group">
                <label for="comentarios">Comentarios:</label>
                <textarea id="comentarios" class="form-control{{ $errors->has('comentarios') ? ' is-invalid' : '' }}" name="comentarios" maxlength="250">{{ old('comentarios', $repuesto->comentarios) }}</textarea>
              </div>
            </fieldset>

            <div class="alert alert-danger alert-important"{!! (count($errors) > 0) ? '' : 'style="display:none"' !!}>
              <ul id="alert-repuesto" class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.repuesto.show', ['repuesto' => $repuesto->id]) }}"><i class="fa fa-reply"></i> Atras</a>
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
    const PORCENTAJE_GANANCIA = @json(Auth::user()->getGlobalGanancia());

    $(document).ready(function () {
      $('#marca, #modelo, #procedencia').select2({
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
            let selected = modelo.id == @json(old('modelo', $repuesto->vehiculo_modelo_id)) ? 'selected' : ''
            $('#modelo').append(`<option value="${modelo.id}" ${selected}>${modelo.modelo}</option>`)
          })

          $('#modelo').prop('disabled', false)
        })
        .fail(function () {
          $('#modelo').prop('disabled', true)
        })
      })
      $('#marca').change();

      $('#procedencia').change(function () {
        let procedencia = $(this).val();
        let isInternacional = procedencia == 'internacional';

        $('#procedencia-title').text(procedencia.charAt(0).toUpperCase() + procedencia.slice(1));

        $('.field-local').prop('disabled', !(procedencia == 'local')).closest('.form-group').toggle(procedencia == 'local');
        $('.field-nacional').prop('disabled', !(procedencia == 'nacional')).closest('.form-group').toggle(procedencia == 'nacional');
        $('.field-internacional').prop('disabled', !isInternacional).closest('.form-group').toggle(isInternacional);
        $('.group-field-internacional').toggle(isInternacional);
        $('#impuestos-internacional').prop('disabled', !isInternacional).closest('.form-group').toggle(isInternacional);
      });
      $('#procedencia').change();

      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id');

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });

      $('#moneda').change(function () {
        let isPeso = $(this).val() == 'peso';

        $('#moneda-valor').prop({'disabled': isPeso, 'required': !isPeso}).closest('.form-group').toggle(!isPeso);
      })
      $('#moneda').change();

      $('.btn-sugerir').click(precioSugerido);
    });


    /* Sugerir precio de venta */
    function precioSugerido() {
      let moneda = $('#moneda').val();
      let valorMoneda = moneda == 'peso' ? 1 : +$('#moneda-valor').val();
      let cantidad = +$('#stock').val();
      let costoRepuesto = +$('#costo').val();

      if(moneda != 'peso' && !valorMoneda){
        showAlert('Debe completar el valor de la moneda seleccionada');
        return;
      }

      if(!cantidad){
        showAlert('Debe introducir una cantidad en Stock');
        return;
      }

      let type = $('#procedencia').val();
      let fieldVenta = $('#venta');
      let gastosGenerales = +$('#generales').val();

      let costo = costoRepuesto * cantidad;
      let porc = costo / (costoRepuesto * cantidad);
      let costoTotal = 0;

      if(type == 'local'){
        costoTotal = costo;
      }else if(type == 'nacional'){
        let flete = +$('#envio').val();
        let envio = flete * porc;

        costoTotal = costo + envio;
      }else{
        let impuestos = +$('#impuestos-internacional').val();
        let flete1 = +$('#envio1-internacional').val();
        let flete2 = +$('#envio2-internacional').val();
        let comisionCasilla = +$('#casilla-internacional').val();
        let envio1 = flete1 * porc;
        let envio2 = flete2 * porc;
        let costoEnvioTotal = costo + envio1 + envio2;

        let impuestoTotal = impuestos * costoEnvioTotal;
        costoTotal = impuestoTotal + ((comisionCasilla * porc) / valorMoneda);
      }

      let gastosGeneralesTotal = costoTotal * gastosGenerales;
      let sugerido = ((gastosGeneralesTotal * valorMoneda) / cantidad);

      fieldVenta.val(sugerido.toFixed(2));
    }

    // Mostrar mensaje de error
    function showAlert(error = 'Ha ocurrido un error.'){
      $('#alert-repuesto').empty().append(`<li>${error}</li>`);
      $('#alert-repuesto').closest('.alert').show().delay(5000).hide('slow');
      scrollToError();
    }

    function scrollToError(){
      $('.main-panel').animate({
        scrollTop: $('#alert-repuesto').offset().top
      }, 500);
    }
  </script>
@endsection
