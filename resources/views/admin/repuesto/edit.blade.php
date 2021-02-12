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
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="generales-internacional">Gastos generales:</label>
                    <select id="generales-internacional" class="custom-select field-internacional" name="generales" disabled>
                      <option value="">Seleccione...</option>
                      <option value="0"{{ old('generales', $repuesto->extra->generales) == '0' ? ' selected' : '' }}>Monto específico</option>
                      <option value="15"{{ old('generales', $repuesto->extra->generales) == '15' ? ' selected' : '' }}>15%</option>
                      <option value="20"{{ old('generales', $repuesto->extra->generales) == '20' ? ' selected' : '' }}>20%</option>
                      <option value="25"{{ old('generales', $repuesto->extra->generales) == '25' ? ' selected' : '' }}>25%</option>
                      <option value="30"{{ old('generales', $repuesto->extra->generales) == '30' ? ' selected' : '' }}>30%</option>
                    </select>
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="generales_total-internacional">Especificar gastos generales:</label>
                    <input id="generales_total-internacional" class="form-control{{ $errors->has('generales_total') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales_total" value="{{ old('generales_total', $repuesto->extra->generales_total) }}" placeholder="Especificar">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="envio">Envio:</label>
                    <input id="envio" class="form-control field-nacional{{ $errors->has('envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio" value="{{ old('envio', $repuesto->envio) }}" placeholder="Envio">
                  </div>
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="impuestos-internacional">Impuestos:</label>
                    <select id="impuestos-internacional" class="custom-select field-internacional" name="impuestos">
                      <option value="">Seleccione...</option>
                      <option value="0"{{ old('impuestos', $repuesto->extra->impuestos) == '0' ? ' selected' : '' }}>Monto específico</option>
                      <option value="19"{{ old('impuestos', $repuesto->extra->impuestos) == '19' ? ' selected' : '' }}>19% del FOB</option>
                      <option value="25"{{ old('impuestos', $repuesto->extra->impuestos) == '25' ? ' selected' : '' }}>25% del FOB</option>
                    </select>
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="impuestos_total-internacional">Especificar impuestos:</label>
                    <input id="impuestos_total-internacional" class="form-control{{ $errors->has('impuestos_total') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="impuestos_total" value="{{ old('impuestos_total', $repuesto->extra->impuestos_total) }}" placeholder="Especificar">
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
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="tramitacion-internacional">Costo tramitación:</label>
                    <input id="tramitacion-internacional" class="form-control field-internacional{{ $errors->has('tramitacion') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="tramitacion" maxlength="50" value="{{ old('tramitacion', $repuesto->extra->tramitacion) }}" placeholder="Costo tramitación">
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

      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id');

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });

      $('#procedencia').change(function () {
        let procedencia = $(this).val();

        $('#procedencia-title').text(procedencia.charAt(0).toUpperCase() + procedencia.slice(1));

        $('#generales').prop('disabled', (procedencia == 'internacional')).closest('.form-group').toggle(!(procedencia == 'internacional'));
        $('.field-local').prop('disabled', !(procedencia == 'local')).closest('.form-group').toggle(procedencia == 'local');
        $('.field-nacional').prop('disabled', !(procedencia == 'nacional')).closest('.form-group').toggle(procedencia == 'nacional');
        $('.field-internacional').prop('disabled', !(procedencia == 'internacional')).closest('.form-group').toggle(procedencia == 'internacional');
        $('.group-field-internacional').toggle(procedencia == 'internacional');

        if(procedencia != 'internacional'){
          $('#generales_total-internacional, #impuestos_total-internacional').prop('disabled', true).closest('.form-group').toggle(false);
        }else{
          $('#impuestos-internacional, #generales-internacional').change();
        }
      });
      $('#procedencia').change();

      $('#impuestos-internacional').change(function () {
        let isZero = $(this).val() == '0';
        $('#impuestos_total-internacional').prop('disabled', !isZero).closest('.form-group').toggle(isZero);
      })
      $('#impuestos-internacional').change();

      $('#generales-internacional').change(function () {
        let isZero = $(this).val() == '0';
        $('#generales_total-internacional').prop('disabled', !isZero).closest('.form-group').toggle(isZero);
      })
      $('#generales-internacional').change();

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

      if(moneda != 'peso' && !valorMoneda){
        showAlert('Debe completar el valor de la moneda seleccionada');
        return;
      }

      let type = $('#procedencia').val();
      let field = $('#venta');
      let costo = (+$('#costo').val() * valorMoneda);
      let generales = +$('#generales').val();
      let subtotal = 0;

      if(type == 'local'){
        subtotal = (costo + (generales * valorMoneda));
      }else if(type == 'nacional'){
        let envio = +$('#envio').val();
        subtotal += costo + (generales * valorMoneda) + (envio * valorMoneda);
      }else{
        let envio1 = (+$('#envio1-internacional').val() * valorMoneda);
        let envio2 = (+$('#envio2-internacional').val() * valorMoneda);
        let casilla = +$('#casilla-internacional').val();
        let impuestos = +$('#impuestos-internacional').val();
        let impuestosTotal = (+$('#impuestos_total-internacional').val() * valorMoneda);
        let generalesTotal = (+$('#generales_total-internacional').val() * valorMoneda);
        let tramitacion = +$('#tramitacion-internacional').val();
        let generalesInternacional = +$('#generales-internacional').val();

        subtotal += costo + envio1 + envio2;
        impuestosTotal = (impuestos > 0) ? calculateImpuestosTotal(subtotal, impuestos) : impuestosTotal;
        subtotal += impuestosTotal + casilla;
        generalesTotal = (generalesInternacional > 0) ? calculateGeneralesTotal(subtotal, generalesInternacional) : generalesTotal;
        subtotal += generalesTotal + tramitacion;
      }

      let total = subtotal + ((subtotal * PORCENTAJE_GANANCIA) / 100);
      field.val(total.toFixed(2));
    }

    // Solo internacional
    function calculateImpuestosTotal(costoBase, impuestos) {
      return (costoBase * impuestos) / 100;
    }

    // Solo internacional
    function calculateGeneralesTotal(costoBase, generales) {
      return (costoBase * generales) / 100;
    }

    // Mostrar mensaje de error
    function showAlert(error = 'Ha ocurrido un error.'){
      $('#alert-repuesto').empty().append(`<li>${error}</li>`);
      $('#alert-repuesto').closest('.alert').show().delay(5000).hide('slow');
      scrollToError();
    }
  </script>
@endsection
